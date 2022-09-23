CREATE PROCEDURE PROC_SC_BOX_INV_STOCK_ITEM_ADD_MER(IN_BOX_LABEL VarChar(20), IN_INV_BOXING_ARRAY VarChar(1024), IN_ROW_COUNT Integer, IN_COL_PARAMETERS Integer, IN_COLUMN_SEPARATOR VarChar(1), IN_ROW_SEPARATOR VarChar(1), USER_ID Integer, IS_UPDATE Integer, IN_WIDTH Integer, IN_LENGTH Integer, IN_HEIGHT Integer, IN_WEIGHT Float, MERCHANT_ID Integer, OUT OUT_STATUS VarChar(500))
  NO SQL
Block1: BEGIN


/*CALL PROC_SC_BOX_INV_STOCK_ITEM_ADD(20100251,'101103111102~1~9|',1,3,'~','|',1,0,@OUT_STATUS);*/

DECLARE int_HAS_cur_PROC_SC_BOX_INV_STOCK INT DEFAULT 1;
    DECLARE xPK_NO INT;
    DECLARE xLIMIT INT;
    DECLARE sPK_NO INT;
    DECLARE var_arrary_param1 VARCHAR(100);
    DECLARE var_arrary_param2 VARCHAR(100);
    DECLARE var_arrary_param3 INT;
    DECLARE var_arrary_row VARCHAR(200);
    DECLARE xCUSTOMER_PREFFERED_SHIPPING_METHOD VARCHAR(200);
    DECLARE var_arrary_row_part VARCHAR(200);
    DECLARE var_inv_stored_pk VARCHAR(20000) DEFAULT 0;
    DECLARE int_row_count INT;
    DECLARE int_row_count_cursor2 INT;
    DECLARE int_is_duplicate_box INT DEFAULT 1;
    DECLARE int_box_pk INT(11);
    DECLARE from_warehouse_no INT(11);
    DECLARE user_name VARCHAR(200);
    DECLARE int_count_updated_row INT DEFAULT 0;
    DECLARE i,j INT;
    DECLARE check_shipment_type VARCHAR(45);
    DECLARE ALL_SUCCESS INT DEFAULT 0;
    DECLARE ALL_SUCCESS_PART INT DEFAULT 1;
    DECLARE inverted_shipment_type VARCHAR(45);
    DECLARE variant_name VARCHAR(500);
    DECLARE is_ship_method_conflict INT DEFAULT 0;
    DECLARE conflict_qty INT DEFAULT 0;
    DECLARE variant_name_with_qty VARCHAR(500);

    DECLARE cur_PROC_SC_BOX_INV_STOCK
        CURSOR FOR
        SELECT
            PK_NO
            FROM MER_INV_STOCK
            WHERE F_INV_WAREHOUSE_NO=var_arrary_param2
            AND (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90 AND PRODUCT_STATUS != 420)
            AND SKUID=var_arrary_param1
            AND FINAL_PREFFERED_SHIPPING_METHOD = check_shipment_type
            LIMIT var_arrary_param3;


        DECLARE CONTINUE HANDLER
            FOR NOT FOUND SET int_HAS_cur_PROC_SC_BOX_INV_STOCK = 0;

            DELETE FROM S;

INSERT INTO S VALUES('Start Procedre');

            SELECT SUBSTRING(IN_BOX_LABEL, 1, 1) INTO check_shipment_type;

            INSERT INTO S VALUES(CONCAT('SC BOX label ' , IN_BOX_LABEL));
            INSERT INTO S VALUES(CONCAT('First_Box ' , check_shipment_type));

            IF check_shipment_type = '3' THEN
               SET check_shipment_type = 'AIR';
            ELSE
               SET check_shipment_type = 'SEA';
            END IF;

            SELECT PK_NO, COUNT(BOX_NO) INTO int_box_pk, int_is_duplicate_box FROM SC_BOX WHERE BOX_NO = IN_BOX_LABEL;

            -- SELECT CONCAT(first_name, ' ', last_name) AS user_name_concate INTO user_name FROM admin_users WHERE auth_id = USER_ID;
DELETE FROM S;
INSERT INTO S VALUES(CONCAT('SC BOX Pk ' , int_box_pk));
INSERT INTO S VALUES(CONCAT('Duplicate Box Flag ', int_is_duplicate_box));
INSERT INTO S VALUES(CONCAT('Shipment Type ' , check_shipment_type));

        IF int_is_duplicate_box != 0 THEN

        CREATE TEMPORARY TABLE temp2_inv_pk_no
               ( inv_pk_no INT );

        UPDATE SC_BOX SET WIDTH_CM = IN_WIDTH, LENGTH_CM = IN_LENGTH, HEIGHT_CM = IN_HEIGHT, WEIGHT_KG = IN_WEIGHT WHERE BOX_NO = IN_BOX_LABEL;
            -- SELECT F_INV_WAREHOUSE_NO INTO from_warehouse_no FROM SS_INV_USER_MAP WHERE F_USER_NO = USER_ID;
            INSERT INTO S VALUES(CONCAT('IN_BOX_LABEL ' , IN_BOX_LABEL));
            INSERT INTO S VALUES(CONCAT('USER_ID ' , USER_ID));
            -- INSERT INTO S VALUES(concat('user_name ' , user_name));
            -- INSERT INTO S VALUES(concat('INV house ' , from_warehouse_no));
            -- INSERT INTO SC_BOX (BOX_NO,F_BOX_USER_NO,USER_NAME,BOX_STATUS,F_INV_WAREHOUSE_NO) VALUES(IN_BOX_LABEL,USER_ID,user_name,10,from_warehouse_no);
            -- SELECT LAST_INSERT_ID() INTO int_box_pk;

INSERT INTO S VALUES(CONCAT('Inserted SC Box Pk ', int_box_pk));
INSERT INTO S VALUES (CONCAT('Parameter Array ',IN_INV_BOXING_ARRAY));

            SET i=1;


            WHILE i <= IN_ROW_COUNT DO
                INSERT INTO S VALUES(CONCAT('loop i val ', i));

                SELECT SUBSTRING_INDEX(IN_INV_BOXING_ARRAY , IN_ROW_SEPARATOR , 1) INTO var_arrary_row;

INSERT INTO S VALUES (CONCAT('Row data ', var_arrary_row));

                SET var_arrary_row_part =  var_arrary_row;



                SELECT SUBSTRING_INDEX(var_arrary_row_part , IN_COLUMN_SEPARATOR , 1) INTO var_arrary_param1;
                SET var_arrary_row_part = SUBSTRING(var_arrary_row_part , LENGTH(var_arrary_param1)+2 , LENGTH(var_arrary_row_part) - LENGTH(var_arrary_param1) );


                SELECT SUBSTRING_INDEX(var_arrary_row_part,IN_COLUMN_SEPARATOR,1) INTO var_arrary_param2;
                SET var_arrary_row_part = SUBSTRING(var_arrary_row_part , LENGTH(var_arrary_param2)+2 , LENGTH(var_arrary_row_part) - LENGTH(var_arrary_param2) );


                SET  var_arrary_param3 = var_arrary_row_part;

                SET IN_INV_BOXING_ARRAY = SUBSTRING(IN_INV_BOXING_ARRAY , LENGTH(var_arrary_row)+2 , LENGTH(IN_INV_BOXING_ARRAY) - LENGTH(var_arrary_row) );




INSERT INTO S VALUES (CONCAT('Param 1   ', var_arrary_param1));
INSERT INTO S VALUES (CONCAT('Param 2   ', var_arrary_param2));
INSERT INTO S VALUES (CONCAT('Param 3   ', var_arrary_param3));


                SET int_HAS_cur_PROC_SC_BOX_INV_STOCK = 1;
                SET int_count_updated_row = 0;
                INSERT INTO S VALUES (CONCAT('Updated Row Count ', int_count_updated_row));
                OPEN cur_PROC_SC_BOX_INV_STOCK;
                SELECT FOUND_ROWS() INTO int_row_count ;

                INSERT INTO S VALUES (CONCAT('Found row before Loop ', int_row_count));

                    IF int_row_count != 0 && int_row_count <= var_arrary_param3 THEN

                    SET ALL_SUCCESS = ALL_SUCCESS + 1;


                    INSERT INTO S VALUES (CONCAT('ALL SUCCESS VAL ', ALL_SUCCESS));
                       /* SET j=0;


INSERT INTO S VALUES(concat('init j val ', j));*/

                    get_PROC_SC_BOX_INV_STOCK:LOOP
                        FETCH NEXT FROM  cur_PROC_SC_BOX_INV_STOCK INTO xPK_NO;

INSERT INTO S VALUES(CONCAT('Loop Control var ', int_HAS_cur_PROC_SC_BOX_INV_STOCK));

                        IF int_HAS_cur_PROC_SC_BOX_INV_STOCK = 0 THEN
                                LEAVE get_PROC_SC_BOX_INV_STOCK;
                        END IF;


INSERT INTO S VALUES(CONCAT('INV Stock PK_NO ', xPK_NO) );

                         UPDATE MER_INV_STOCK
                            SET F_BOX_NO = int_box_pk, PRODUCT_STATUS = 20,BOX_BARCODE = IN_BOX_LABEL,BOX_TYPE=check_shipment_type
                            WHERE PK_NO =  xPK_NO;
                        INSERT INTO MER_SC_BOX_INV_STOCK(F_BOX_NO, F_INV_STOCK_NO,F_MERCHANT_NO) VALUES (int_box_pk,xPK_NO,MERCHANT_ID);
                        /*  SET j = j + 1;*/
                        SET int_count_updated_row = int_count_updated_row + 1;
                        INSERT INTO temp2_inv_pk_no(inv_pk_no) VALUES (xPK_NO);
                        /*if var_inv_stored_pk = 0 THEN
                            SET var_inv_stored_pk = xPK_NO;
                        ELSE
                            SET var_inv_stored_pk = CONCAT(var_inv_stored_pk,',',xPK_NO);
                        END IF;
                        */
                    INSERT INTO S VALUES(CONCAT('var_inv_stored_pk ', var_inv_stored_pk) );

                    END LOOP get_PROC_SC_BOX_INV_STOCK;

                    END IF;

                CLOSE cur_PROC_SC_BOX_INV_STOCK;
                INSERT INTO S VALUES(CONCAT('Updated Rows ', int_count_updated_row) );
                INSERT INTO S VALUES(CONCAT('var_arrary_param3 ', var_arrary_param3) );
                SET xLIMIT = var_arrary_param3 - int_count_updated_row;
                INSERT INTO S VALUES(CONCAT('LIMIT VALUE ', xLIMIT) );

                IF int_count_updated_row < var_arrary_param3 THEN

                /*-------------------------BLOCK 2 BEGINS ------------------------------*/
                Block2: BEGIN
                    DECLARE int_HAS_cur_PROC_SC_BOXING_LIST_INV_STOCK INT DEFAULT 1;

                    DECLARE cur_PROC_SC_BOXING_LIST_INV_STOCK
                    CURSOR FOR
                    SELECT
                        PK_NO,CUSTOMER_PREFFERED_SHIPPING_METHOD
                        FROM MER_INV_STOCK
                        WHERE F_INV_WAREHOUSE_NO=var_arrary_param2
                        AND (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90 AND PRODUCT_STATUS != 420)
                        AND SKUID=var_arrary_param1;


                    DECLARE CONTINUE HANDLER
                        FOR NOT FOUND SET int_HAS_cur_PROC_SC_BOXING_LIST_INV_STOCK = 0;

                OPEN cur_PROC_SC_BOXING_LIST_INV_STOCK;
                    SELECT FOUND_ROWS() INTO int_row_count_cursor2 ;
                    INSERT INTO S VALUES (CONCAT('Found row2 before Loop ', int_row_count_cursor2));

                    IF int_row_count_cursor2 != 0 THEN
                       IF int_count_updated_row = 0 THEN
                          SET ALL_SUCCESS = ALL_SUCCESS + 1;
                       END IF;

                        INSERT INTO S VALUES(CONCAT('ALL_SUCCESS LINE 223 ', ALL_SUCCESS) );
                        get_PROC_SC_BOX_INV_STOCK_TOP:LOOP

                            FETCH NEXT FROM cur_PROC_SC_BOXING_LIST_INV_STOCK  INTO xPK_NO,xCUSTOMER_PREFFERED_SHIPPING_METHOD;

                            INSERT INTO S VALUES(CONCAT('Loop Control var ', int_HAS_cur_PROC_SC_BOXING_LIST_INV_STOCK));
                            INSERT INTO S VALUES(CONCAT('Cus Preferred ', xCUSTOMER_PREFFERED_SHIPPING_METHOD));

                                        IF int_count_updated_row = var_arrary_param3 OR int_HAS_cur_PROC_SC_BOXING_LIST_INV_STOCK = 0 THEN

                                                LEAVE get_PROC_SC_BOX_INV_STOCK_TOP;
                                        END IF;

                            INSERT INTO S VALUES(CONCAT('INV Stock TOP PK_NO ', xPK_NO) );

                            IF xCUSTOMER_PREFFERED_SHIPPING_METHOD IS NULL OR xCUSTOMER_PREFFERED_SHIPPING_METHOD = check_shipment_type THEN

                                UPDATE MER_INV_STOCK
                                    SET F_BOX_NO = int_box_pk, PRODUCT_STATUS = 20,BOX_BARCODE = IN_BOX_LABEL,BOX_TYPE=check_shipment_type
                                    WHERE PK_NO =  xPK_NO;
                                INSERT INTO MER_SC_BOX_INV_STOCK(F_BOX_NO,F_INV_STOCK_NO,F_MERCHANT_NO) VALUES (int_box_pk,xPK_NO,MERCHANT_ID);
                                /*  SET j = j + 1;*/
                                SET int_count_updated_row = int_count_updated_row + 1;
                                INSERT INTO temp2_inv_pk_no(inv_pk_no) VALUES (xPK_NO);
                                /*if var_inv_stored_pk = 0 THEN
                                    SET var_inv_stored_pk = xPK_NO;
                                ELSE
                                    SET var_inv_stored_pk = CONCAT(var_inv_stored_pk,',',xPK_NO);
                                END IF;
                                */
                                INSERT INTO S VALUES(CONCAT('var_inv_stored_pk ', var_inv_stored_pk) );

                                INSERT INTO S VALUES(CONCAT('Updated Rows ', int_count_updated_row) );

                ELSEIF xCUSTOMER_PREFFERED_SHIPPING_METHOD <> check_shipment_type THEN
                                   IF check_shipment_type = 'SEA' THEN
                                      SET inverted_shipment_type = 'AIR';
                                   ELSE
                                      SET inverted_shipment_type = 'SEA';
                                   END IF;
                                   SELECT PRD_VARINAT_NAME INTO variant_name FROM MER_INV_STOCK WHERE PK_NO = xPK_NO;
                                   SET is_ship_method_conflict = 1;
                                   SET conflict_qty = int_row_count_cursor2;
                                   INSERT INTO S VALUES(CONCAT('variant Name ', variant_name) );
                                   INSERT INTO S VALUES(CONCAT('is_ship_method_conflict ', is_ship_method_conflict) );
                                   INSERT INTO S VALUES(CONCAT('conflict_qty ', conflict_qty) );
                            END IF;


                        END LOOP get_PROC_SC_BOX_INV_STOCK_TOP;
                    END IF;

                CLOSE cur_PROC_SC_BOXING_LIST_INV_STOCK;

                END Block2;
                /*-------------------------BLOCK 2 ENDS ------------------------------*/

                   IF int_count_updated_row != var_arrary_param3 THEN

                     SET ALL_SUCCESS_PART = 0;
                   END IF;

                END IF;

                SET i = i + 1;

            END WHILE;

                  /* IF ALL_SUCCESS_PART = 0 THEN
                    SET OUT_STATUS = 'failed-partial';

                  ELSE */
                  INSERT INTO S VALUES(CONCAT('ALL_SUCCESS_PART ', ALL_SUCCESS_PART) );
                  INSERT INTO S VALUES(CONCAT('ALL_SUCCESS ', ALL_SUCCESS) );
                  INSERT INTO S VALUES(CONCAT('IN_ROW_COUNT ', IN_ROW_COUNT) );
                  IF ALL_SUCCESS = IN_ROW_COUNT AND ALL_SUCCESS_PART = 1 THEN
                     SET OUT_STATUS = 'success';

          ELSEIF is_ship_method_conflict = 1 THEN
                     SET variant_name = CONCAT('Method Conflict for ',variant_name);
                     SET variant_name_with_qty = CONCAT(' => QTY ',conflict_qty);
                     SET OUT_STATUS = CONCAT(variant_name,variant_name_with_qty);
                     INSERT INTO S VALUES(CONCAT('OUT STATUS ', OUT_STATUS));
                    SELECT PK_NO INTO int_box_pk FROM SC_BOX WHERE BOX_NO = IN_BOX_LABEL;
                    UPDATE MER_INV_STOCK
                           SET F_BOX_NO = NULL,
                               PRODUCT_STATUS = NULL,
                               BOX_BARCODE = NULL,
                               BOX_TYPE = NULL
                           WHERE PK_NO IN (SELECT inv_pk_no FROM temp2_inv_pk_no);

                    DELETE FROM MER_SC_BOX_INV_STOCK
                    WHERE F_INV_STOCK_NO IN (SELECT inv_pk_no FROM temp2_inv_pk_no);

                  ELSE
                    SET OUT_STATUS = 'failed';
                    INSERT INTO S VALUES(CONCAT('var_inv_stored_pk ', var_inv_stored_pk) );
                    SELECT PK_NO INTO int_box_pk FROM SC_BOX WHERE BOX_NO = IN_BOX_LABEL;
                    UPDATE MER_INV_STOCK
                           SET F_BOX_NO = NULL,
                               PRODUCT_STATUS = NULL,
                               BOX_BARCODE = NULL,
                               BOX_TYPE = NULL
                           WHERE PK_NO IN (SELECT inv_pk_no FROM temp2_inv_pk_no);

                    DELETE FROM MER_SC_BOX_INV_STOCK
                    WHERE F_INV_STOCK_NO IN (SELECT inv_pk_no FROM temp2_inv_pk_no) ;


                    -- DELETE FROM SC_BOX WHERE PK_NO = int_box_pk;

                   END IF;

        DROP TEMPORARY TABLE IF EXISTS temp2_inv_pk_no;
        ELSE
           SET OUT_STATUS = 'box-not-found';

        END IF;

INSERT INTO S VALUES(CONCAT('End of Procedure with status ', OUT_STATUS));

END Block1
/
