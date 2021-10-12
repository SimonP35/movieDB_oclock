# Dictionnaire de données - Projet : Moviedb

## Casting

| Field        | Types        | Spécificity                                     | Description                    |
| ------------ | ------------ | ----------------------------------------------- | ------------------------------ |
| id           | INT(11)      | PRIMARY KEY, NOT NULL, AUTO_INCREMENT, UNSIGNED | Casting's ID                   |
| role         | VARCHAR(255) | NOT NULL                                        | Casting's role                 |
| credit_order | SMALLINT(6)  | NOT NULL                                        | Casting's credit_order         |
| created_at   | DATETIME     | NOT NULL, DEFAULT CURRENT_TIMESTAMP             | Date of creation               |
| updated_at   | DATETIME     | NULL                                            | Date of update                 |
| person_id    | INT(11)      | NOT NULL, INDEX                                 | Person's id related to Casting |
| movie_id     | INT(11)      | NOT NULL, INDEX                                 | Movie's id related to Casting  |

## Department

| Field      | Types        | Spécificity                                     | Description       |
| ---------- | ------------ | ----------------------------------------------- | ----------------- |
| id         | INT(11)      | PRIMARY KEY, NOT NULL, AUTO_INCREMENT, UNSIGNED | Department's ID   |
| name       | VARCHAR(255) | NOT NULL                                        | Department's name |
| created_at | DATETIME     | NOT NULL, DEFAULT CURRENT_TIMESTAMP             | Date of creation  |
| updated_at | DATETIME     | NULL                                            | Date of update    |

## Genre

| Field      | Types        | Spécificity                                     | Description      |
| ---------- | ------------ | ----------------------------------------------- | ---------------- |
| id         | INT(11)      | PRIMARY KEY, NOT NULL, AUTO_INCREMENT, UNSIGNED | Genre's ID       |
| name       | VARCHAR(255) | NOT NULL                                        | Genre's name     |
| slug       | VARCHAR(255) | NOT NULL                                        | Genre's slug     |
| created_at | DATETIME     | NOT NULL, DEFAULT CURRENT_TIMESTAMP             | Date of creation |
| updated_at | DATETIME     | NULL                                            | Date of update   |

## Job

| Field         | Types        | Spécificity                                     | Description                    |
| ------------- | ------------ | ----------------------------------------------- | ------------------------------ |
| id            | INT(11)      | PRIMARY KEY, NOT NULL, AUTO_INCREMENT, UNSIGNED | Job's ID                       |
| name          | VARCHAR(255) | NOT NULL                                        | Job's name                     |
| created_at    | DATETIME     | NOT NULL, DEFAULT CURRENT_TIMESTAMP             | Date of creation               |
| updated_at    | DATETIME     | NULL                                            | Date of update                 |
| department_id | INT(11)      | NOT NULL, INDEX                                 | Department's id related to Job |

## Movie

| Field        | Types        | Spécificity                                     | Description          |
| ------------ | ------------ | ----------------------------------------------- | -------------------- |
| id           | INT(11)      | PRIMARY KEY, NOT NULL, AUTO_INCREMENT, UNSIGNED | Movie's ID           |
| title        | VARCHAR(211) | NOT NULL, UNIQUE                                | Movie's title        |
| duration     | INT(11)      | NOT NULL                                        | Movie's duration     |
| poster       | VARCHAR(255) | NULL                                            | Movie's poster's URL |
| rating       | SMALLINT(6)  | NULL                                            | Movie's rating       |
| slug         | VARCHAR(255) | NOT NULL, UNIQUE                                | Movie's slug         |
| synopsis     | LONGTEXT     | NOT NULL                                        | Movie's synopsis     |
| release_date | DATETIME     | NOT NULL                                        | Movie's release date |
| created_at   | DATETIME     | NOT NULL, DEFAULT CURRENT_TIMESTAMP             | Date of creation     |
| updated_at   | DATETIME     | NULL                                            | Date of update       |

## Movie_Genre

| Field    | Types   | Spécificity                  | Description                       |
| -------- | ------- | ---------------------------- | --------------------------------- |
| movie_id | INT(11) | NOT NULL, PRIMARY KEY, INDEX | Movie's id related to Movie_Genre |
| genre_id | INT(11) | NOT NULL, PRIMARY KEY, INDEX | Genre's id related to Movie_Genre |

## Person

| Field      | Types        | Spécificity                                     | Description        |
| ---------- | ------------ | ----------------------------------------------- | ------------------ |
| id         | INT(11)      | PRIMARY KEY, NOT NULL, AUTO_INCREMENT, UNSIGNED | Person's ID        |
| firstname  | VARCHAR(255) | NOT NULL                                        | Person's firstname |
| lastname   | VARCHAR(255) | NOT NULL                                        | Person's lastname  |
| created_at | DATETIME     | NOT NULL, DEFAULT CURRENT_TIMESTAMP             | Date of creation   |
| updated_at | DATETIME     | NULL                                            | Date of update     |

## Review

| Field        | Types        | Spécificity                                     | Description                       |
| ------------ | ------------ | ----------------------------------------------- | --------------------------------- |
| id           | INT(11)      | PRIMARY KEY, NOT NULL, AUTO_INCREMENT, UNSIGNED | Review's ID                       |
| username     | VARCHAR(50)  | NOT NULL                                        | Review's username                 |
| email        | VARCHAR(255) | NOT NULL                                        | Review's email                    |
| content      | LONGTEXT     | NOT NULL                                        | Review's content                  |
| rating       | SMALLINT(6)  | NOT NULL                                        | Review's rating                   |
| reactions    | LONGTEXT     | NOT NULL                                        | Review's reactions (DC2Type:json) |
| watched_at   | DATETIME     | NOT NULL                                        | Watch date                        |
| published_at | DATETIME     | NOT NULL, DEFAULT CURRENT_TIMESTAMP             | Date of publication               |
| created_at   | DATETIME     | NOT NULL, DEFAULT CURRENT_TIMESTAMP             | Date of creation                  |
| updated_at   | DATETIME     | NULL                                            | Date of update                    |
| movie_id     | INT(11)      | NOT NULL, INDEX                                 | Movie's id related to Review      |

## Team

| Field     | Types   | Spécificity                                     | Description                 |
| --------- | ------- | ----------------------------------------------- | --------------------------- |
| id        | INT(11) | PRIMARY KEY, NOT NULL, AUTO_INCREMENT, UNSIGNED | Team's ID                   |
| movie_id  | INT(11) | NOT NULL, INDEX                                 | Movie's id related to Team  |
| person_id | INT(11) | NOT NULL, INDEX                                 | Person's id related to Team |
| job_id    | INT(11) | NOT NULL, INDEX                                 | Job's id related to Team    |

## User

| Field      | Types        | Spécificity                                     | Description                 |
| ---------- | ------------ | ----------------------------------------------- | --------------------------- |
| id         | INT(11)      | PRIMARY KEY, NOT NULL, AUTO_INCREMENT, UNSIGNED | User's ID                   |
| email      | VARCHAR(180) | NOT NULL, UNIQUE                                | User's email                |
| roles      | LONGTEXT     | NOT NULL                                        | User's roles (DC2Type:json) |
| password   | VARCHAR(255) | NOT NULL                                        | User's password             |
| created_at | DATETIME     | NOT NULL, DEFAULT CURRENT_TIMESTAMP             | Date of creation            |
| updated_at | DATETIME     | NULL                                            | Date of update              |
