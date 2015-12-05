create database elites_blog;

use elites_blog;

grant all on elites_blog.* to testuser@localhost identified by '9999';

create table users (
  id int primary key auto_increment,
  name varchar(255),
  email varchar(255),
  created_at datetime
);

create table posts (
  id int primary key auto_increment,
  name varchar(255),
  title varchar(255),
  content text,
  created_at datetime,
  updated_at datetime
);