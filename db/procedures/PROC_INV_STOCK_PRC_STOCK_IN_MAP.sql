CREATE PROCEDURE PROC_INV_STOCK_PRC_STOCK_IN_MAP(IN_PK_NO Integer)
  NO SQL
BEGIN

    /*PROC_INV_STOCK_PRC_STOCK_IN_MAP*/
    DECLARE int_F_PRC_STOCK_IN_NO INT(11) default 0;
    DECLARE int_SHOP_NO           INT(11) default 0;
    DECLARE xSHOP_NAME            varchar(200);

    /*PRC_STOCK_IN_DETAILS*/
    DECLARE int_HAS_DATA_PRC_STOCK_IN_DETAILS INT DEFAULT 1;
    DECLARE int_RECIEVED_QTY INT;
    DECLARE int_FAULTY_QTY INT;
    DECLARE int_TOTAL INT;

    /*INV STOCK*/
    DECLARE xCODE                            INT;
    DECLARE xF_INV_STOCK_PRC_STOCK_IN_MAP_NO INT;
    DECLARE xF_PRD_MASTER_SETUP_NO           INT;
    DECLARE xF_PRC_STOCK_IN_NO               INT;
    DECLARE xF_PRC_STOCK_IN_DETAILS_NO       INT;
    DECLARE xIG_CODE                         varchar(20);
    DECLARE xSKUID                           varchar(40);
    DECLARE xF_PRD_VARIANT_NO                INT;
    DECLARE xPRD_VARINAT_NAME                varchar(200);
    DECLARE xINVOICE_NAME                    varchar(200);
    DECLARE xF_CATEGORY_NO                   INT;
    DECLARE xCATEGORY_NAME                   varchar(200);
    DECLARE xBARCODE                         varchar(40);
    DECLARE xPRODUCT_PURCHASE_PRICE          FLOAT;
    DECLARE xPRODUCT_REGULAR_PRICE           FLOAT;
    DECLARE xPRODUCT_SPECIAL_PRICE           FLOAT;
    DECLARE xPRODUCT_INSTALLMENT_PRICE       FLOAT;
    DECLARE xPRODUCT_WHOLESALE_PRICE         FLOAT;
    DECLARE xPRC_IN_IMAGE_PATH               varchar(200);
    DECLARE xPRD_VARIANT_IMAGE_PATH          varchar(200);

    /*LOOP VARIABLES*/
    DECLARE i int DEFAULT 0;

    DECLARE cur_PRC_STOCK_IN_DETAILS
        CURSOR FOR
                SELECT
                        INVOICE.F_PRC_STOCK_IN
                        ,INVOICE.PK_NO
                        ,INVOICE.F_PRD_VARIANT_NO
                        ,PRODUCT.MRK_ID_COMPOSITE_CODE
                        ,PRODUCT.COMPOSITE_CODE
                        ,PRODUCT.F_PRD_MASTER_SETUP_NO
                        ,PRODUCT.VARIANT_NAME
                        ,INVOICE.INVOICE_NAME
                        ,PRODUCT.BARCODE
                        ,INVOICE.UNIT_PRICE_MR_EV
                        ,INVOICE.RECIEVED_QTY
                        ,INVOICE.FAULTY_QTY
                        ,PRODUCT.REGULAR_PRICE
                        ,PRODUCT.SPECIAL_PRICE
                        ,PRODUCT.INSTALLMENT_PRICE
                        ,PRODUCT.WHOLESALE_PRICE
                        ,INVOICE_MASTER.MASTER_INVOICE_RELATIVE_PATH
                        ,PRODUCT.PRIMARY_IMG_RELATIVE_PATH
                        ,PRODUCT_CATEGORY.PK_NO
                        ,PRODUCT_CATEGORY.NAME

                        FROM
                            PRC_STOCK_IN INVOICE_MASTER
                            ,PRC_STOCK_IN_DETAILS INVOICE
                            ,PRD_VARIANT_SETUP PRODUCT
                            ,PRD_MASTER_SETUP PRODUCT_MASTER
                            ,PRD_CATEGORY PRODUCT_CATEGORY

                        WHERE
                    INVOICE.F_PRC_STOCK_IN = int_F_PRC_STOCK_IN_NO
                        AND  INVOICE.F_PRD_VARIANT_NO = PRODUCT.PK_NO
                        AND PRODUCT.F_PRD_MASTER_SETUP_NO=  PRODUCT_MASTER.PK_NO
                        AND PRODUCT_MASTER.F_PRD_CATEGORY_ID=  PRODUCT_CATEGORY.PK_NO
                        AND INVOICE_MASTER.PK_NO = INVOICE.F_PRC_STOCK_IN
                            ;

    DECLARE CONTINUE HANDLER
    FOR NOT FOUND SET int_HAS_DATA_PRC_STOCK_IN_DETAILS=0;


    SELECT F_PRC_STOCK_IN_NO , F_SHOP_NO
        INTO int_F_PRC_STOCK_IN_NO, int_SHOP_NO
    FROM INV_STOCK_PRC_STOCK_IN_MAP
    WHERE PK_NO = IN_PK_NO ;

    SELECT USERNAME
        INTO xSHOP_NAME
    FROM SA_USER
    WHERE PK_NO = int_SHOP_NO
    AND F_PARENT_USER_ID = 0;

    OPEN cur_PRC_STOCK_IN_DETAILS;

        insert into R values ('105');

                get_PRC_STOCK_IN_DETAILS: LOOP

                        FETCH NEXT FROM  cur_PRC_STOCK_IN_DETAILS INTO

                        xF_PRC_STOCK_IN_NO               ,
                        xF_PRC_STOCK_IN_DETAILS_NO       ,
                        xF_PRD_VARIANT_NO                ,
                        xIG_CODE                         ,
                        xSKUID                           ,
                        xF_PRD_MASTER_SETUP_NO           ,
                        xPRD_VARINAT_NAME                ,
                        xINVOICE_NAME                    ,
                        xBARCODE                         ,
                        xPRODUCT_PURCHASE_PRICE          ,
                        int_RECIEVED_QTY                 ,
                        int_FAULTY_QTY                   ,
                        xPRODUCT_REGULAR_PRICE           ,
                        xPRODUCT_SPECIAL_PRICE           ,
                        xPRODUCT_INSTALLMENT_PRICE       ,
                        xPRODUCT_WHOLESALE_PRICE         ,
                        xPRC_IN_IMAGE_PATH               ,
                        xPRD_VARIANT_IMAGE_PATH          ,
                        xF_CATEGORY_NO                   ,
                        xCATEGORY_NAME                   ;



        /*TOTAL GEN = RECQTY - FAUTLY QTY*/
        IF int_HAS_DATA_PRC_STOCK_IN_DETAILS = 0 THEN
            LEAVE get_PRC_STOCK_IN_DETAILS;

        END IF;

        SET int_TOTAL = int_RECIEVED_QTY - int_FAULTY_QTY;


        SET i=0;
        WHILE i < int_TOTAL DO

            insert into INV_STOCK(
                F_INV_STOCK_PRC_STOCK_IN_MAP_NO
                ,F_PRD_MASTER_SETUP_NO
                ,F_PRC_STOCK_IN_NO
                ,F_PRC_STOCK_IN_DETAILS_NO
                ,IG_CODE
                ,SKUID
                ,F_PRD_VARIANT_NO
                ,PRD_VARINAT_NAME
                ,INVOICE_NAME
                ,F_CATEGORY_NO
                ,CATEGORY_NAME
                ,BARCODE
                ,PRODUCT_PURCHASE_PRICE
                ,REGULAR_PRICE
                ,SPECIAL_PRICE
                ,INSTALLMENT_PRICE
                ,WHOLESALE_PRICE
                ,PRC_IN_IMAGE_PATH
                ,PRD_VARIANT_IMAGE_PATH
                ,F_SHOP_NO
                ,F_SHOP_NAME
            )
            VALUES

            (

            IN_PK_NO
            ,xF_PRD_MASTER_SETUP_NO
            ,xF_PRC_STOCK_IN_NO
            ,xF_PRC_STOCK_IN_DETAILS_NO
            ,xIG_CODE
            ,xSKUID
            ,xF_PRD_VARIANT_NO
            ,xPRD_VARINAT_NAME
            ,xINVOICE_NAME
            ,xF_CATEGORY_NO
            ,xCATEGORY_NAME
            ,xBARCODE
            ,xPRODUCT_PURCHASE_PRICE
            ,xPRODUCT_REGULAR_PRICE
            ,xPRODUCT_SPECIAL_PRICE
            ,xPRODUCT_INSTALLMENT_PRICE
            ,xPRODUCT_WHOLESALE_PRICE
            ,xPRC_IN_IMAGE_PATH
            ,xPRD_VARIANT_IMAGE_PATH
            ,int_SHOP_NO
            ,xSHOP_NAME
            );

            SET i = i + 1;

        END WHILE;



    END LOOP get_PRC_STOCK_IN_DETAILS;


    /* UPDATE INV_STOCK_PRC_STOCK_IN_MAP
    SET PROCESS_COMPLETE_TIME = NOW()
    WHERE PK_NO=IN_PK_NO;     */


CLOSE cur_PRC_STOCK_IN_DETAILS;


/*
if (int_HAS_DATA_PRC_STOCK_IN_DETAILS = 0)
return

    */

/*insert into INV_STOCK(CODE,INVOICE_NAME,PRD_VARIANT_NAME,HS_CODE,BAR_CODE)

SELECT CODE,INVOICE_NAME,PRD_VARIANT_NAME,HS_CODE,BAR_CODE

FROM PRC_STOCK_IN_DETAILS

WHERE PK_NO = IN_PK_NO;*/

END
/
