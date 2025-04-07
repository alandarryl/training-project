
create database training_database;

use training_database;


-- Create a table for storing user information
create table users(
    id int auto_increment primary key,
    username varchar(50) not null,
    password varchar(255) not null,
    email varchar(50) not null,
    phone varchar(20) not null,
    address varchar(255) not null,
    city varchar(50) not null,
    gender varchar(10) not null,
    date_of_birth date not null,
    profile_picture varchar(255) not null,
    created_at datetime default current_timestamp
);

-- create table for product publish by user 

create table products(
    id int auto_increment primary key,
    user_id int not null,
    product_name varchar(255) not null,
    product_description text not null,
    product_price decimal(10,2) not null,
    product_quantity int not null,
    product_image varchar(255) not null,
    created_at datetime default current_timestamp,
    foreign key (user_id) references users(id)
);


-- Create a table for storing product information

create table categories(
    id int auto_increment primary key,
    category_name varchar(50) not null,
    created_at datetime default current_timestamp
);
