import { getIronSession } from 'iron-session';
import { sessionOptions } from '../../lib/session';
import { getDb } from '../../lib/db';
import Link from 'next/link';
import { useRouter } from 'next/router';

const PREVIEW_IMAGES = [
  '/images/stage1-preview.jpg',
  '/images/stage2-preview.jpg',
  '/images/stage3-preview.jpg',
  '/images/stage4-preview.jpg',
  '/images/stage5-preview.jpg',
  '/images/stage6-preview.jpg',
];

export async function getServerSideProps({ req, res, params }) {
  const session = await getIronSession(req, res, sessionOptions);
  if (!session.userId) return { redirect: { destination: '/login', permanent: false } };

  const stageId = parseInt(params.id, 10);
  if (isNaN(stageId) || stageId < 1 || stageId > 6) return { notFound: true };

  const db = getDb();
  const [statusRows] = await db.query('SELECT stage FROM status2 WHERE userID = ?', [session.userId]);
  if (!statusRows.length || statusRows[0].stage < stageId) {
    return { redirect: { destination: '/stage', permanent: false } };
  }

  let ranking = [];
  try {
    const [rankRows] = await db.query(
      `SELECT score, name FROM ranking_st${stageId} ORDER BY score DESC LIMIT 5`
    );
    ranking = rankRows;
  } catch {
    // Table may not exist yet
  }

  return { props: { stageId, ranking } };
}

export default function StageStartPage({ stageId, ranking }) {
  const router = useRouter();

  return (
    <div>
      <div className="game-box">
        <div className="page-title">St{stageId}</div>
        <Link href="/stage" className="close-btn">×</Link>

        <img
          src={PREVIEW_IMAGES[stageId - 1]}
          alt={`Stage ${stageId}`}
          onClick={() => router.push(`/game?stage=${stageId}`)}
          style={{
            position: 'absolute',
            top: 130,
            left: 50,
            border: '1px solid black',
            cursor: 'pointer',
            transition: 'opacity 0.3s',
          }}
          onMouseEnter={e => { e.currentTarget.style.opacity = '0.6'; }}
          onMouseLeave={e => { e.currentTarget.style.opacity = '1'; }}
        />

        <div style={{ position: 'absolute', top: 100, left: 380, fontSize: 19 }}>ランキングTop5</div>
        <div style={{
          position: 'absolute', top: 130, left: 300,
          width: 280, height: 250, border: '1px solid black', padding: 8, overflow: 'auto',
        }}>
          {ranking.length ? (
            <table>
              <tbody>
                {ranking.map((r, i) => (
                  <tr key={i}>
                    <td style={{ paddingRight: 12 }}>{i + 1}</td>
                    <td style={{ paddingRight: 12 }}>{r.score}</td>
                    <td>{r.name}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          ) : (
            <p style={{ margin: 0, fontSize: 13, color: '#666' }}>データがありません</p>
          )}
        </div>
      </div>
    </div>
  );
}
