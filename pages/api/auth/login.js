import { getIronSession } from 'iron-session';
import { sessionOptions } from '../../../lib/session';
import { getDb } from '../../../lib/db';
import bcrypt from 'bcryptjs';

export default async function handler(req, res) {
  if (req.method !== 'POST') return res.status(405).end();

  const { userID, password } = req.body;
  if (!userID || !password) return res.status(400).json({ error: '入力が不正です' });

  const db = getDb();
  const [rows] = await db.query('SELECT * FROM Users WHERE userID = ?', [userID]);
  if (!rows.length) return res.status(401).json({ error: 'ユーザーIDまたはパスワードが違います' });

  const user = rows[0];
  // Support both bcrypt hashes (new) and plain text (legacy migration)
  const valid = user.password.startsWith('$2')
    ? await bcrypt.compare(password, user.password)
    : password === user.password;

  if (!valid) return res.status(401).json({ error: 'ユーザーIDまたはパスワードが違います' });

  const session = await getIronSession(req, res, sessionOptions);
  session.userId = user.userID;
  session.name = user.name;
  await session.save();
  res.json({ ok: true });
}
