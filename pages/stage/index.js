import { getIronSession } from 'iron-session';
import { sessionOptions } from '../../lib/session';
import { getDb } from '../../lib/db';
import Link from 'next/link';
import { useRouter } from 'next/router';

const STAGE_IMAGES = [
  '/images/stage1.jpg',
  '/images/stage2.jpg',
  '/images/stage3.jpg',
  '/images/stage4.jpg',
  '/images/stage5.jpg',
  '/images/stage6.jpg',
];

// Alternating left/right columns, 3 rows each
const POSITIONS = [
  { left: 65, top: 100 },
  { left: 65, top: 200 },
  { left: 65, top: 300 },
  { left: 350, top: 100 },
  { left: 350, top: 200 },
  { left: 350, top: 300 },
];

export async function getServerSideProps({ req, res }) {
  const session = await getIronSession(req, res, sessionOptions);
  if (!session.userId) return { redirect: { destination: '/login', permanent: false } };
  const db = getDb();
  const [rows] = await db.query('SELECT stage FROM status2 WHERE userID = ?', [session.userId]);
  if (!rows.length) return { redirect: { destination: '/login', permanent: false } };
  return { props: { stageProgress: rows[0].stage } };
}

export default function StageSelectPage({ stageProgress }) {
  const router = useRouter();

  return (
    <div>
      <div className="game-box">
        <div className="page-title">ステージ選択</div>
        <Link href="/homepage" className="close-btn">×</Link>

        {Array.from({ length: Math.min(stageProgress, 6) }, (_, i) => (
          <div
            key={i}
            style={{
              position: 'absolute',
              width: 200,
              height: 60,
              left: POSITIONS[i].left,
              top: POSITIONS[i].top,
              cursor: 'pointer',
            }}
            onClick={() => router.push(`/stage/${i + 1}`)}
            onMouseEnter={e => { const img = e.currentTarget.querySelector('img'); if (img) img.style.opacity = '0.6'; }}
            onMouseLeave={e => { const img = e.currentTarget.querySelector('img'); if (img) img.style.opacity = '1'; }}
          >
            <img
              src={STAGE_IMAGES[i]}
              alt={`Stage ${i + 1}`}
              style={{ width: 200, height: 60, border: '1px solid #ccc', transition: 'opacity 0.3s' }}
            />
            <span style={{ position: 'absolute', top: 0, left: -35, fontSize: 20 }}>St{i + 1}</span>
          </div>
        ))}
      </div>
    </div>
  );
}
