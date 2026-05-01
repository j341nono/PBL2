import mysql from 'mysql2/promise';

let pool;

export function getDb() {
  if (!pool) {
    if (process.env.DATABASE_URL) {
      pool = mysql.createPool(process.env.DATABASE_URL + '?waitForConnections=true&connectionLimit=10');
    } else {
      pool = mysql.createPool({
        host: process.env.DB_HOST || 'localhost',
        user: process.env.DB_USER || 'root',
        password: process.env.DB_PASSWORD || '',
        database: process.env.DB_NAME || 'pbl2',
        waitForConnections: true,
        connectionLimit: 10,
      });
    }
  }
  return pool;
}
