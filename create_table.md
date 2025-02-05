CREATE TABLE `course_table` (
	`Student ID` CHAR(9) NOT NULL DEFAULT '' COLLATE 'utf8mb4_0900_ai_ci',
	`Course Code` CHAR(5) NOT NULL DEFAULT '' COLLATE 'utf8mb4_0900_ai_ci',
	`Test 1` FLOAT(4,1) UNSIGNED NULL DEFAULT NULL,
	`Test 2` FLOAT(4,1) UNSIGNED NULL DEFAULT NULL,
	`Test 3` FLOAT(4,1) UNSIGNED NULL DEFAULT NULL,
	`Final exam` FLOAT(4,1) UNSIGNED NULL DEFAULT NULL,
	PRIMARY KEY (`Student ID`, `Course Code`) USING BTREE
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;

CREATE TABLE `name_table` (
	`Student ID` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`Student Name` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_0900_ai_ci',
	PRIMARY KEY (`Student ID`) USING BTREE
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;

INSERT INTO `course_table` (`Student ID`, `Course Code`, `Test 1`, `Test 2`, `Test 3`, `Final exam`) VALUES ('123456789', 'CP111', 0.0, 0.0, 0.0, 0.0);
INSERT INTO `course_table` (`Student ID`, `Course Code`, `Test 1`, `Test 2`, `Test 3`, `Final exam`) VALUES ('123456789', 'CP222', 0.0, 0.0, 0.0, 0.0);
INSERT INTO `course_table` (`Student ID`, `Course Code`, `Test 1`, `Test 2`, `Test 3`, `Final exam`) VALUES ('222222222', 'CP476', 100.0, 100.0, 100.0, 69.0);
INSERT INTO `course_table` (`Student ID`, `Course Code`, `Test 1`, `Test 2`, `Test 3`, `Final exam`) VALUES ('987654321', 'CP476', 100.0, 100.0, 100.0, 100.0);
