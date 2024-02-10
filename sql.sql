create database if not exists ucs;
use ucs;
create table `uc` (
iduc bigint not null auto_increment,
`code` varchar(20) not null,
`name` varchar(255) not null,
`description` varchar(255)   null, 
`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP not null ,
`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP  not null ON UPDATE CURRENT_TIMESTAMP ,
 primary key (iduc),
 unique (code)
);