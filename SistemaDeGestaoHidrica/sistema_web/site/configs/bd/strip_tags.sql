DELIMITER //
DROP FUNCTION IF EXISTS `STRIP_TAGS`//
CREATE FUNCTION STRIP_TAGS( x longtext) RETURNS longtext
LANGUAGE SQL NOT DETERMINISTIC READS SQL DATA
BEGIN
	DECLARE sstart INT UNSIGNED;
	DECLARE ends INT UNSIGNED;
	
	IF x IS NOT NULL THEN
		SET sstart = LOCATE('<', x, 1);
		REPEAT
			SET ends = LOCATE('>', x, sstart);
			SET x = CONCAT(SUBSTRING( x, 1 ,sstart -1) ,SUBSTRING(x, ends +1 )) ;
			SET sstart = LOCATE('<', x, 1);
		UNTIL sstart < 1
		END REPEAT;
	END IF;
	
	RETURN x;
END;
//