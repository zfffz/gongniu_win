create table users (
id varchar(63),
no varchar(63),
name varchar(63),
password varchar(63),
dept_name varchar(63),
primary key(id)
);
insert into users (id,no,name,password,dept_name) values
('01','01','秦韬','PU8r8H3BvjiyDNbkaUmhBx+dDj0=','IT'),
('02','02','钱源','p/EmpqlLpNUMlcDmt9lxJPxqxYs=','IT'),
('03','03','梁冬兴','PU8r8H3BvjiyDNbkaUmhBx+dDj0=','IT'),
('05','05','张峰','jv/uQJxiXhotj1AzYxhA5s4dy2Q=','IT');

create table customer (
cCusCode varchar(63),
cCusName varchar(127),
primary key(cCusCode)
);
insert into customer(cCusCode,cCusName) values
('30071','上海玲怡实业有限公司'),
('30126','上海署维机电有限公司'),
('30150','上海华供五金交电有限公司'),
('30042','上海德珮实业发展有限公司'),
('20142','迎信（上海）实业有限公司'),
('20263','上海育佑文化发展有限公司'),
('40007','7号车销'),
('20225','上海欧士通机电设备有限公司'),
('20046','上海市浦东新区宣桥镇华怡五金装潢经营部'),
('30222','上海科谐电器成套设备有限公司'),
('30032','上海宪薇五金机电有限公司');

create table bs_gn_wl (
cpersoncode varchar(63),
cpersonname varchar(63),
wlcode varchar(63),
primary key(cpersoncode)
);
insert into bs_gn_wl(cpersoncode,cpersonname,wlcode) values
('3024','鲍纲辉','03'),
('3028','吴成艮','03'),
('3010','王永华','03'),
('3002','宋爱国','03'),
('3037','徐辉','03'),
('3021','李必忠','03'),
('3027','冉茂伟','03');

create table dispatchlist (
cDLCode varchar(63),
cCusCode varchar(63),
primary key(cDLCode)
);
insert into dispatchlist(cDLCode,cCusCode) values
('XSFH00000001','30071'),
('XSFH00000002','30126'),
('XSFH00000004','30150'),
('XSFH00000005','30042'),
('XSFH00000006','20142'),
('XSFH00000007','20263'),
('XSFH00000008','40007'),
('XSFH00000009','20225'),
('XSFH00000010','20046'),
('XSFH00000011','30222'),
('XSFH00000012','30032');
