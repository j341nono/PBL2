import { getIronSession } from 'iron-session';
import { sessionOptions } from '../../../lib/session';
import { getDb } from '../../../lib/db';

const ITEM_CONFIG = {
  item1: { cost: 20,  field: 'item1', isGear: false, max: 99 },
  item2: { cost: 80,  field: 'item2', isGear: false, max: 99 },
  item3: { cost: 200, field: 'item3', isGear: false, max: 99 },
  Gear1: { cost: 200, field: 'Gear1', isGear: true },
  Gear2: { cost: 200, field: 'Gear2', isGear: true },
  Gear3: { cost: 200, field: 'Gear3', isGear: true },
  Gear4: { cost: 200, field: 'Gear4', isGear: true },
};

export default async function handler(req, res) {
  if (req.method !== 'POST') return res.status(405).end();
  const session = await getIronSession(req, res, sessionOptions);
  if (!session.userId) return res.status(401).json({ error: '未ログインです' });

  const { type } = req.body;
  const config = ITEM_CONFIG[type];
  if (!config) return res.status(400).json({ error: '存在しないアイテムです' });

  const db = getDb();
  const [rows] = await db.query(
    'SELECT gold, ?? AS currentVal FROM status2 WHERE userID = ?',
    [config.field, session.userId]
  );
  if (!rows.length) return res.status(404).json({ error: 'ユーザーが見つかりません' });

  const { gold, currentVal } = rows[0];
  if (gold < config.cost) return res.status(400).json({ error: `ゴールドが不足しています（${config.cost}G必要）` });

  if (config.isGear) {
    if (currentVal > 0) return res.status(400).json({ error: 'すでに所持しています' });
    await db.query(
      'UPDATE status2 SET gold = gold - ?, ?? = 1 WHERE userID = ?',
      [config.cost, config.field, session.userId]
    );
  } else {
    if (currentVal >= config.max) return res.status(400).json({ error: `これ以上持てません（上限${config.max}個）` });
    await db.query(
      'UPDATE status2 SET gold = gold - ?, ?? = ?? + 1 WHERE userID = ?',
      [config.cost, config.field, config.field, session.userId]
    );
  }

  res.json({ ok: true });
}
