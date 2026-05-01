import { getIronSession } from 'iron-session';
import { sessionOptions } from '../lib/session';

export async function getServerSideProps({ req, res }) {
  const session = await getIronSession(req, res, sessionOptions);
  if (session.userId) {
    return { redirect: { destination: '/homepage', permanent: false } };
  }
  return { redirect: { destination: '/login', permanent: false } };
}

export default function Home() {
  return null;
}
