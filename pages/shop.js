import { getIronSession } from 'iron-session';
import { sessionOptions } from '../lib/session';
import { getDb } from '../lib/db';
import { useRouter } from 'next/router';
import Link from 'next/link';

export async function getServerSideProps({ req, res }) {
  const session = await getIronSession(req, res, sessionOptions);
  if (!session.userId) {
    return { redirect: { destination: '/login', permanent: false } };
  }
  const db = getDb();
  const [rows] = await db.query('SELECT * FROM status2 WHERE userID = ?', [session.userId]);
  if (!rows.length) return { redirect: { destination: '/login', permanent: false } };
  const s = rows[0];
  return {
    props: {
      gold: s.gold,
      item1: s.item1, item2: s.item2, item3: s.item3,
      Gear1: s.Gear1, Gear2: s.Gear2, Gear3: s.Gear3, Gear4: s.Gear4,
    },
  };
}

export default function ShopPage({ gold, item1, item2, item3, Gear1, Gear2, Gear3, Gear4 }) {
  const router = useRouter();

  async function buy(type, amount) {
    const res = await fetch('/api/shop/buy', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ type, amount }),
    });
    const json = await res.json();
    if (res.ok) {
      router.replace(router.asPath);
    } else {
      alert(json.error || '購入失敗');
    }
  }

  const imgStyle = { border: '2px solid black', marginLeft: 0 };
  const itemLabelStyle = { textAlign: 'center', fontSize: 12, marginTop: 4 };
  const countStyle = { textAlign: 'center', fontSize: 11, color: '#555' };

  return (
    <div>
      <div className="game-box">
        <div style={{ position: 'absolute', top: 5, left: 5, fontSize: 30, fontWeight: 'bold' }}>ショップ</div>
        <div style={{ position: 'absolute', top: 12, left: 300, fontSize: 20 }}>所持金：{gold}G</div>
        <Link href="/homepage" className="close-btn">×</Link>

        {/* Items row */}
        <div style={{ position: 'absolute', top: 70, left: 80, display: 'flex', gap: 20 }}>
          {[
            { name: '薬草', src: '/images/herb.jpg', count: item1, type: 'item1', cost: 20 },
            { name: '上薬草', src: '/images/superior-herb.jpg', count: item2, type: 'item2', cost: 80 },
            { name: 'ポーション', src: '/images/potion.jpg', count: item3, type: 'item3', cost: 200 },
          ].map(item => (
            <div key={item.type} style={{ display: 'flex', flexDirection: 'column', alignItems: 'center' }}>
              <img src={item.src} alt={item.name} style={imgStyle} />
              <div style={itemLabelStyle}>{item.name}</div>
              <div style={countStyle}>{item.cost}G・所持{item.count}</div>
              <button className="btn" style={{ marginTop: 4, width: 60, height: 28 }} onClick={() => buy(item.type, item.cost)}>購入</button>
            </div>
          ))}
        </div>

        {/* Gear row */}
        <div style={{ position: 'absolute', top: 240, left: 15, display: 'flex', gap: 15 }}>
          {[
            { name: '貫通', src: Gear1 ? '/images/sell-penetration.jpg' : '/images/penetration.jpg', type: 'Gear1', owned: Gear1 },
            { name: 'シールド', src: Gear2 ? '/images/sell-shield.jpg' : '/images/shield.jpg', type: 'Gear2', owned: Gear2 },
            { name: '弾数UP', src: Gear3 ? '/images/sell-bullet-up.jpg' : '/images/bullet-up.jpg', type: 'Gear3', owned: Gear3 },
            { name: '無敵', src: Gear4 ? '/images/sell-invincible.jpg' : '/images/invincible.jpg', type: 'Gear4', owned: Gear4 },
          ].map(gear => (
            <div key={gear.type} style={{ display: 'flex', flexDirection: 'column', alignItems: 'center' }}>
              <img src={gear.src} alt={gear.name} style={imgStyle} />
              <div style={itemLabelStyle}>{gear.name}</div>
              <div style={countStyle}>200G</div>
              {!gear.owned
                ? <button className="btn" style={{ marginTop: 4, width: 60, height: 28 }} onClick={() => buy(gear.type, 200)}>購入</button>
                : <span style={{ fontSize: 11, color: 'green', marginTop: 4 }}>所持中</span>
              }
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}
