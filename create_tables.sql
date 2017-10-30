CREATE TABLE User(
    username varchar(20) PRIMARY KEY,
    password varchar(40),
    type char(2), CHECK (type IN ('ST','TA'))
);

CREATE TABLE Question(
    q_id int(7) PRIMARY KEY,
    s_id REFERENCES Session(s_id),
    username REFERENCES User(username),
    t_stamp timestamp,
    question_content varchar(1000),
    answer_content varchar(1000),
);

CREATE TABLE Session(
    s_id varchar(10) PRIMARY KEY,
    class_name varchar(10),
    t_stamp timestamp,
);

