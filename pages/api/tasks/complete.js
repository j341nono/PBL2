import { getIronSession } from 'iron-session';
import { sessionOptions } from '../../../lib/session';
import { getDb } from '../../../lib/db';

export default async function handler(req, res) {
  if (req.method !== 'POST') return res.status(405).end();
  const session = await getIronSession(req, res, sessionOptions);
  if (!session.userId) return res.status(401).json({ error: '未ログインです' });

  const { taskIDs } = req.body;
  if (!Array.isArray(taskIDs) || !taskIDs.length) {
    return res.status(400).json({ error: 'タスクが選択されていません' });
  }

  const db = getDb();
  const conn = await db.getConnection();
  try {
    await conn.beginTransaction();

    let totalGold = 0;
    for (const id of taskIDs) {
      const [rows] = await conn.query(
        'SELECT addgold FROM UserTasks2 WHERE userID = ? AND taskID = ?',
        [session.userId, Number(id)]
      );
      if (rows.length) totalGold += rows[0].addgold;
    }

    await conn.query(
      'UPDATE status2 SET gold = gold + ? WHERE userID = ?',
      [totalGold, session.userId]
    );

    for (const id of taskIDs) {
      await conn.query(
        'DELETE FROM UserTasks2 WHERE userID = ? AND taskID = ?',
        [session.userId, Number(id)]
      );
    }

    await conn.commit();
    res.json({ ok: true, gold: totalGold });
  } catch (e) {
    await conn.rollback();
    res.status(500).json({ error: 'サーバーエラーが発生しました' });
  } finally {
    conn.release();
  }
}
