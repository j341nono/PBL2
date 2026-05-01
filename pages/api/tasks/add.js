import { getIronSession } from 'iron-session';
import { sessionOptions } from '../../../lib/session';
import { getDb } from '../../../lib/db';

export default async function handler(req, res) {
  if (req.method !== 'POST') return res.status(405).end();
  const session = await getIronSession(req, res, sessionOptions);
  if (!session.userId) return res.status(401).json({ error: '未ログインです' });

  const { todolist, addgold, startdate, enddate, period } = req.body;
  if (!todolist || !addgold || !startdate || !enddate || !period) {
    return res.status(400).json({ error: '入力が不正です' });
  }
  if (!['daily', 'weekly', 'monthly'].includes(period)) {
    return res.status(400).json({ error: '不正な期間です' });
  }

  const db = getDb();
  const [result] = await db.query(
    'SELECT IFNULL(MAX(taskID), 0) + 1 AS next FROM UserTasks2 WHERE userID = ?',
    [session.userId]
  );
  const nextId = result[0].next;

  await db.query(
    'INSERT INTO UserTasks2 (userID, taskID, todolist, addgold, startdate, enddate, period) VALUES (?, ?, ?, ?, ?, ?, ?)',
    [session.userId, nextId, todolist, Number(addgold), startdate, enddate, period]
  );
  res.json({ ok: true });
}
