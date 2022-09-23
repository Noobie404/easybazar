CREATE PROCEDURE PROC_CUSTOMER_AREA_RETRIEVE(IN_LATITUDE float, IN_LONGITUTE float)
  NO SQL
BLOCKPARENT: BEGIN

        DECLARE xF_MIN_LATITUDE     INT;
        DECLARE xF_MIN_LONGITUDE    INT;
        DECLARE xF_MAX_LATITUDE     INT;
        DECLARE xF_MAX_LONGITUDE    INT; 
        DECLARE xF_SUB_AREA_ID      INT;   
        DECLARE int_row_count       INT;
                  
        
Block1: BEGIN
        DECLARE COUNTER1 INT DEFAULT 1;
        DECLARE INT_HAS_CUR_SUB_AREA_LIST INT DEFAULT 1;
   
        DECLARE CUR_SUB_AREA_LIST
            CURSOR FOR
                SELECT
                     SS_SUB_AREA.PK_NO
                    ,SS_SUB_AREA.MIN_LAT
                    ,SS_SUB_AREA.MIN_LON
                    ,SS_SUB_AREA.MAX_LAT
                    ,SS_SUB_AREA.MAX_LON 
                    ,SS_SUB_AREA.TOTAL_NODE
                   

                FROM
                    SS_SUB_AREA
                    
                WHERE 
                     -- SS_SUB_AREA.MIN_LAT < '23.79307746887207'    
                    -- AND SS_SUB_AREA.MIN_LON < '90.40473175048828'
                    -- AND SS_SUB_AREA.MAX_LAT > '23.79307746887207'     
                    -- AND SS_SUB_AREA.MAX_LON > '90.40473175048828';
                    
                    SS_SUB_AREA.MIN_LAT < IN_LATITUDE    
                    AND SS_SUB_AREA.MIN_LON < IN_LONGITUTE
                    AND SS_SUB_AREA.MAX_LAT > IN_LATITUDE     
                    AND SS_SUB_AREA.MAX_LON > IN_LONGITUTE;


            -- INSERT INTO S VALUES('Line 102');
        DECLARE CONTINUE HANDLER
    FOR NOT FOUND SET INT_HAS_CUR_SUB_AREA_LIST = 0;


INSERT INTO S VALUES('Line 48');

            OPEN CUR_SUB_AREA_LIST;
                SELECT FOUND_ROWS() INTO int_row_count ;

INSERT INTO S values ('Line 53');
INSERT INTO S values (concat('Found row ', int_row_count));

       IF int_row_count > 0 THEN

                    GET_IS_IN_SUBAREA: LOOP
                        FETCH NEXT
                        FROM  CUR_SUB_AREA_LIST
                            INTO
                            xF_BOOKING_NO
                            ,xF_INV_STOCK_NO
                            ,xREGULAR_PRICE
                            ,xINSTALLMENT_PRICE
                            ,xF_PRD_VARIANT_NO
                            ,xLIST_NO
                            ,xLIST_DTL_NO
                            ,xF_BUNDLE_NO
                            ,xLIST
                            ;
                    -- INSERT INTO S VALUES('line 48');
                    END LOOP GET_IS_IN_SUBAREA;
                END IF;
            CLOSE CUR_SUB_AREA_LIST;
END Block1;

END BLOCKPARENT
/
