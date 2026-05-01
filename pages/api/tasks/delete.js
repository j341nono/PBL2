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
  for (const id of taskIDs) {
    await db.query(
      'DELETE FROM UserTasks2 WHERE userID = ? AND taskID = ?',
      [session.userId, Number(id)]
    );
  }
  res.json({ ok: true });
}
