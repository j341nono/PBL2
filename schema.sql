-- PBL2 Database Schema
-- Run this on your cloud MySQL instance (PlanetScale, Railway, etc.)

CREATE TABLE IF NOT EXISTS Users (
  userID   INT          AUTO_INCREMENT PRIMARY KEY,
  name     VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS status2 (
  userID     INT PRIMARY KEY,
  gold       INT NOT NULL DEFAULT 10000,
  hp         INT NOT NULL DEFAULT 75,
  power      INT NOT NULL DEFAULT 10,
  point      INT NOT NULL DEFAULT 14,
  hppoint    INT NOT NULL DEFAULT 0,
  powerpoint INT NOT NULL DEFAULT 0,
  item1      INT NOT NULL DEFAULT 0,
  item2      INT NOT NULL DEFAULT 0,
  item3      INT NOT NULL DEFAULT 0,
  Gear1      INT NOT NULL DEFAULT 0,
  Gear2      INT NOT NULL DEFAULT 0,
  Gear3      INT NOT NULL DEFAULT 0,
  Gear4      INT NOT NULL DEFAULT 0,
  stage      INT NOT NULL DEFAULT 1,
  FOREIGN KEY (userID) REFERENCES Users(userID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS UserTasks2 (
  userID    INT          NOT NULL,
  taskID    INT          NOT NULL,
  todolist  VARCHAR(500) NOT NULL,
  addgold   INT          NOT NULL,
  startdate DATE         NOT NULL,
  enddate   DATE         NOT NULL,
  period    VARCHAR(20)  NOT NULL,
  PRIMARY KEY (userID, taskID),
  FOREIGN KEY (userID) REFERENCES Users(userID) ON DELETE CASCADE
);

-- Ranking tables (created automatically by the app on first score save,
-- but you can pre-create them here)
CREATE TABLE IF NOT EXISTS ranking_st1 (
  userID INT PRIMARY KEY,
  score  INT          NOT NULL DEFAULT 0,
  name   VARCHAR(100) NOT NULL DEFAULT '',
  FOREIGN KEY (userID) REFERENCES Users(userID) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS ranking_st2 LIKE ranking_st1;
CREATE TABLE IF NOT EXISTS ranking_st3 LIKE ranking_st1;
CREATE TABLE IF NOT EXISTS ranking_st4 LIKE ranking_st1;
CREATE TABLE IF NOT EXISTS ranking_st5 LIKE ranking_st1;
CREATE TABLE IF NOT EXISTS ranking_st6 LIKE ranking_st1;
