import { getIronSession } from 'iron-session';
import { sessionOptions } from '../lib/session';
import { getDb } from '../lib/db';
import Head from 'next/head';
import { useEffect } from 'react';

export async function getServerSideProps({ req, res, query }) {
  const session = await getIronSession(req, res, sessionOptions);
  if (!session.userId) return { redirect: { destination: '/login', permanent: false } };

  const stageNum = Math.max(1, Math.min(6, parseInt(query.stage, 10) || 1));
  const db = getDb();
  const [rows] = await db.query('SELECT * FROM status2 WHERE userID = ?', [session.userId]);
  if (!rows.length) return { redirect: { destination: '/login', permanent: false } };
  const s = rows[0];

  return {
    props: {
      userId: session.userId,
      hp: s.hp,
      power: s.power,
      item1: s.item1,
      item2: s.item2,
      item3: s.item3,
      diagonal: s.Gear1,
      behind: s.Gear2,
      stageProgress: s.stage,
      stageNum,
    },
  };
}

const GAME_SCRIPTS = [
  '/game/constants.js',
  '/game/math.js',
  '/game/gameLogic.js',
  '/game/sprite.js',
  '/game/view.js',
  '/game/explosion.js',
  '/game/shot.js',
  '/game/player.js',
  '/game/monster.js',
  '/game/stage1.js',
  '/game/stage2.js',
  '/game/stage3.js',
  '/game/stage4.js',
  '/game/stage5.js',
  '/game/stage6.js',
  '/game/stage.js',
  '/game/title.js',
  '/game/main.js',
];

export default function GamePage({ userId, hp, power, item1, item2, item3, diagonal, behind, stageProgress, stageNum }) {
  useEffect(() => {
    // Define sendGameData globally before loading game scripts
    window.sendGameData = function(score, item1Val, item2Val, item3Val, stage, stageCleared) {
      const uid = document.getElementById('userid').value;
      const progress = parseInt(document.getElementById('progress').value, 10);
      let newProgress = progress;
      if (stage >= progress && stageCleared && progress < 6) newProgress = progress + 1;

      const xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
          window.location.href = '/homepage';
        }
      };
      xhr.open('POST', '/api/game/save-score', true);
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.send(JSON.stringify({
        userID: uid,
        score,
        item1: item1Val,
        item2: item2Val,
        item3: item3Val,
        stage,
        stage_progress: newProgress,
      }));
    };

    // Load game scripts sequentially (order matters due to global variable dependencies)
    const loadScript = src => new Promise((resolve, reject) => {
      const script = document.createElement('script');
      script.src = src;
      script.onload = resolve;
      script.onerror = () => reject(new Error(`Failed to load ${src}`));
      document.body.appendChild(script);
    });

    (async () => {
      for (const src of GAME_SCRIPTS) {
        await loadScript(src);
      }
    })();

    return () => {
      GAME_SCRIPTS.forEach(src => {
        const el = document.querySelector(`script[src="${src}"]`);
        if (el) el.remove();
      });
      delete window.sendGameData;
    };
  }, []);

  return (
    <>
      <Head>
        <title>Game</title>
        <link rel="stylesheet" href="/game/styles.css" />
      </Head>

      {/* Hidden inputs read by game JS at load time */}
      <input id="userid" type="hidden" defaultValue={userId} />
      <input id="HP" type="hidden" defaultValue={hp} />
      <input id="attack" type="hidden" defaultValue={power} />
      <input id="item1" type="hidden" defaultValue={item1} />
      <input id="item2" type="hidden" defaultValue={item2} />
      <input id="item3" type="hidden" defaultValue={item3} />
      <input id="diagonal" type="hidden" defaultValue={diagonal} />
      <input id="behind" type="hidden" defaultValue={behind} />
      <input id="progress" type="hidden" defaultValue={stageProgress} />
      <input id="stage_select" type="hidden" defaultValue={stageNum} />

      <audio id="bgm" loop>
        <source src="/game/Swords.mp3" type="audio/mpeg" />
      </audio>

      <div id="game-container">
        <canvas id="can" width="320" height="320"></canvas>
        <div id="title" style={{ textAlign: 'center' }}></div>
        <div id="title2" style={{ textAlign: 'center' }}></div>
      </div>
    </>
  );
}
