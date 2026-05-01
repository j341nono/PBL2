import { getIronSession } from 'iron-session';
import { sessionOptions } from '../../../lib/session';
import { getDb } from '../../../lib/db';

export default async function handler(req, res) {
  if (req.method !== 'POST') return res.status(405).end();
  const session = await getIronSession(req, res, sessionOptions);
  if (!session.userId) return res.status(401).json({ error: '未ログインです' });

  const { action } = req.body;
  const db = getDb();
  const [rows] = await db.query('SELECT * FROM status2 WHERE userID = ?', [session.userId]);
  if (!rows.length) return res.status(404).json({ error: 'ユーザーが見つかりません' });
  const s = rows[0];

  if (action === 'hp') {
    if (s.gold < 100) return res.status(400).json({ error: 'ゴールドが不足しています（100G必要）' });
    if (s.point < 2) return res.status(400).json({ error: 'ステータスポイントが不足しています（2pt必要）' });
    if (s.hppoint >= 5) return res.status(400).json({ error: 'HPの強化は上限（5回）です' });
    await db.query(
      'UPDATE status2 SET gold = gold - 100, hp = hp + 25, point = point - 2, hppoint = hppoint + 1 WHERE userID = ?',
      [session.userId]
    );
  } else if (action === 'power') {
    if (s.gold < 50) return res.status(400).json({ error: 'ゴールドが不足しています（50G必要）' });
    if (s.point < 1) return res.status(400).json({ error: 'ステータスポイントが不足しています（1pt必要）' });
    if (s.powerpoint >= 10) return res.status(400).json({ error: '攻撃力の強化は上限（10回）です' });
    await db.query(
      'UPDATE status2 SET gold = gold - 50, power = power + 1, point = point - 1, powerpoint = powerpoint + 1 WHERE userID = ?',
      [session.userId]
    );
  } else if (action === 'reset') {
    if (s.gold < 500) return res.status(400).json({ error: 'ゴールドが不足しています（500G必要）' });
    await db.query(
      'UPDATE status2 SET gold = gold - 500, hp = 75, power = 10, point = 14, hppoint = 0, powerpoint = 0 WHERE userID = ?',
      [session.userId]
    );
  } else {
    return res.status(400).json({ error: '不正なアクションです' });
  }

  res.json({ ok: true });
}
