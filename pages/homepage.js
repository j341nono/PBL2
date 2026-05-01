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
  const [rows] = await db.query(
    'SELECT s.*, u.name FROM status2 s JOIN Users u ON s.userID = u.userID WHERE s.userID = ?',
    [session.userId]
  );
  if (!rows.length) {
    return { redirect: { destination: '/login', permanent: false } };
  }
  const status = rows[0];
  return {
    props: {
      userId: session.userId,
      name: status.name,
      gold: status.gold,
      hp: status.hp,
      power: status.power,
      point: status.point,
      hppoint: status.hppoint,
      powerpoint: status.powerpoint,
    },
  };
}

export default function Homepage({ userId, name, gold, hp, power, point, hppoint, powerpoint }) {
  const router = useRouter();

  async function handleUpgrade(action) {
    const res = await fetch('/api/user/upgrade', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ action }),
    });
    const json = await res.json();
    if (res.ok) {
      router.replace(router.asPath);
    } else {
      alert(json.error || 'エラーが発生しました');
    }
  }

  async function handleLogout() {
    await fetch('/api/auth/logout', { method: 'POST' });
    router.push('/login');
  }

  const hpBars = Array.from({ length: hppoint }, (_, i) => (
    <div key={i} style={{ width: 28, height: 20, backgroundColor: 'rgb(118, 223, 140)', borderRight: '1px solid black' }} />
  ));
  const powerBars = Array.from({ length: powerpoint }, (_, i) => (
    <div key={i} style={{ width: 14, height: 20, backgroundColor: 'rgb(226, 137, 137)', borderRight: '1px solid black' }} />
  ));

  return (
    <div>
      <div className="game-box">
        {/* Name + Gold */}
        <div style={{ position: 'absolute', top: 40, left: 80, display: 'flex', alignItems: 'flex-start' }}>
          <div style={{ width: 10, height: 45, backgroundColor: '#ae642f' }} />
          <div style={{ marginLeft: 5 }}>
            ID:{userId}&emsp;{name}<br />所持金：{gold}G
          </div>
        </div>

        {/* Status Reset */}
        <button
          className="btn"
          style={{ position: 'absolute', top: 120, left: 80, width: 200, height: 25, textAlign: 'center' }}
          onClick={() => handleUpgrade('reset')}
        >
          ステータスリセット&emsp;500G
        </button>

        {/* Stat Points */}
        <div style={{ position: 'absolute', top: 160, left: 70, width: 220 }}>
          残りステータスポイント：{point}
        </div>

        {/* HP Bar */}
        <div style={{ position: 'absolute', top: 190, left: 20, width: 140, height: 20, border: '1px solid black', display: 'flex' }}>
          {hpBars}
        </div>

        {/* Power Bar */}
        <div style={{ position: 'absolute', top: 190, left: 190, width: 140, height: 20, border: '1px solid black', display: 'flex' }}>
          {powerBars}
        </div>

        {/* HP Upgrade Button */}
        <button
          className="btn"
          style={{ position: 'absolute', top: 220, left: 35, width: 110, height: 25, backgroundColor: 'white' }}
          onClick={() => handleUpgrade('hp')}
          onMouseEnter={e => e.target.style.backgroundColor = 'rgb(118, 223, 140)'}
          onMouseLeave={e => e.target.style.backgroundColor = 'white'}
        >
          HP&emsp;100G
        </button>

        {/* Power Upgrade Button */}
        <button
          className="btn"
          style={{ position: 'absolute', top: 220, left: 205, width: 110, height: 25, backgroundColor: 'white' }}
          onClick={() => handleUpgrade('power')}
          onMouseEnter={e => e.target.style.backgroundColor = 'rgb(226, 137, 137)'}
          onMouseLeave={e => e.target.style.backgroundColor = 'white'}
        >
          攻撃&emsp;50G
        </button>

        {/* Hero image */}
        <img
          src="/images/hero.jpg"
          alt="勇者"
          style={{ position: 'absolute', top: 40, left: 360, border: '1px solid black' }}
        />

        {/* Bottom navigation images */}
        <img
          src="/images/shop.jpg"
          alt="ショップ"
          onClick={() => router.push('/shop')}
          style={{ position: 'absolute', top: 280, left: 33, border: '1px solid black', cursor: 'pointer', transition: 'opacity 0.3s' }}
          onMouseEnter={e => e.target.style.opacity = '0.6'}
          onMouseLeave={e => e.target.style.opacity = '1'}
        />
        <img
          src="/images/mission.jpg"
          alt="ミッション"
          onClick={() => router.push('/tasks')}
          style={{ position: 'absolute', top: 280, left: 224, border: '1px solid black', cursor: 'pointer', transition: 'opacity 0.3s' }}
          onMouseEnter={e => e.target.style.opacity = '0.6'}
          onMouseLeave={e => e.target.style.opacity = '1'}
        />
        <img
          src="/images/stage-select.jpg"
          alt="ステージ選択"
          onClick={() => router.push('/stage')}
          style={{ position: 'absolute', top: 280, left: 416, border: '1px solid black', cursor: 'pointer', transition: 'opacity 0.3s' }}
          onMouseEnter={e => e.target.style.opacity = '0.6'}
          onMouseLeave={e => e.target.style.opacity = '1'}
        />
      </div>

      <div style={{ textAlign: 'center', marginTop: 16 }}>
        <button className="btn" onClick={handleLogout}>ログアウト</button>
      </div>
    </div>
  );
}
