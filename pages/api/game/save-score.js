import { getDb } from '../../../lib/db';

export default async function handler(req, res) {
  if (req.method !== 'POST') return res.status(405).end();

  const { userID, score, item1, item2, item3, stage, stage_progress } = req.body;
  if (!userID || score == null || !stage) return res.status(400).json({ error: '不正なリクエストです' });

  const stageNum = parseInt(stage, 10);
  if (isNaN(stageNum) || stageNum < 1 || stageNum > 6) return res.status(400).json({ error: '不正なステージ番号です' });

  const db = getDb();
  const [userRows] = await db.query('SELECT name FROM Users WHERE userID = ?', [userID]);
  if (!userRows.length) return res.status(404).json({ error: 'ユーザーが見つかりません' });
  const name = userRows[0].name;

  const tableName = `ranking_st${stageNum}`;
  try {
    const [existing] = await db.query(`SELECT score FROM ${tableName} WHERE userID = ?`, [userID]);
    if (!existing.length) {
      await db.query(`INSERT INTO ${tableName} (userID, score, name) VALUES (?, ?, ?)`, [userID, score, name]);
    } else if (existing[0].score < score) {
      await db.query(`UPDATE ${tableName} SET score = ?, name = ? WHERE userID = ?`, [score, name, userID]);
    }
  } catch {
    // Create ranking table if it doesn't exist yet
    await db.query(
      `CREATE TABLE IF NOT EXISTS ${tableName} (userID INT PRIMARY KEY, score INT NOT NULL DEFAULT 0, name VARCHAR(100) NOT NULL DEFAULT '')`
    );
    await db.query(`INSERT INTO ${tableName} (userID, score, name) VALUES (?, ?, ?)`, [userID, score, name]);
  }

  await db.query(
    'UPDATE status2 SET item1 = ?, item2 = ?, item3 = ?, stage = ? WHERE userID = ?',
    [
      Math.max(0, parseInt(item1, 10) || 0),
      Math.max(0, parseInt(item2, 10) || 0),
      Math.max(0, parseInt(item3, 10) || 0),
      parseInt(stage_progress, 10) || stageNum,
      userID,
    ]
  );

  res.json({ ok: true });
}
