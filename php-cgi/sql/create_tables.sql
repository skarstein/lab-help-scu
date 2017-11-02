CREATE TABLE User(
    username varchar(20),
    salt varchar(22),
    password varchar(60),
    type char(2), CHECK (type IN ('ST','TA')),
    PRIMARY KEY (username)
);

CREATE TABLE Session(
    s_id varchar(10),
    class_name varchar(10),
    t_stamp timestamp,
    PRIMARY KEY (s_id)
);

CREATE TABLE Question(
    q_id int(7),
    s_id varchar(10),
    username varchar(20),
    t_stamp timestamp,
    question_content varchar(1000),
    answer_content varchar(1000),
    PRIMARY KEY (q_id),
    FOREIGN KEY(s_id) REFERENCES Session(s_id),
    FOREIGN KEY(username) REFERENCES User(username) ON DELETE CASCADE
);


