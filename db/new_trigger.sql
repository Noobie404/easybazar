CREATE TRIGGER BEFORE_MER_PRC_STOCK_IN_INSERT
  BEFORE INSERT
  ON MER_PRC_STOCK_IN FOR EACH ROW
BEGIN
declare PKCODE int(11) default 0;

select IFNULL(max(CODE),100) into PKCODE
from MER_PRC_STOCK_IN;
SET NEW.CODE = PKCODE+1 ;
END


CREATE TRIGGER BEFORE_SC_MERCHANT_BILL_INSERT
  BEFORE INSERT
  ON SC_MERCHANT_BILL FOR EACH ROW
BEGIN
declare PKCODE int(11) default 0;
declare VAR_SHIPMENT_NO int(11) default 0;

select IFNULL(max(CODE),100) into PKCODE
from SC_MERCHANT_BILL;
SET NEW.CODE = PKCODE+1 ;
SELECT CODE INTO VAR_SHIPMENT_NO FROM SC_SHIPMENT WHERE PK_NO = NEW.F_SHIPMENT_NO;
SET NEW.SHIPMENT_NO = VAR_SHIPMENT_NO;
END


CREATE TRIGGER AFTER_MER_PRC_STOCK_IN_INSERT
  AFTER INSERT
  ON MER_PRC_STOCK_IN FOR EACH ROW
BEGIN
    DECLARE VAR_CUM_ORDERS_VAL FLOAT DEFAULT 0;
    DECLARE VAR_MER_CUM_ORDERS_VAL FLOAT DEFAULT 0;

    SELECT SUM(INVOICE_TOTAL_ACTUAL_GBP),  SUM(MER_INVOICE_TOTAL_ACTUAL_GBP) INTO VAR_CUM_ORDERS_VAL, VAR_MER_CUM_ORDERS_VAL FROM MER_PRC_STOCK_IN WHERE F_MERCHANT_NO = NEW.F_MERCHANT_NO;

    UPDATE SLS_MERCHANT  SET CUM_ORDERS_VAL = VAR_CUM_ORDERS_VAL, VAR_CUM_ORDERS_VAL = VAR_MER_CUM_ORDERS_VAL WHERE PK_NO = NEW.F_MERCHANT_NO;

END

CREATE TRIGGER AFTER_MER_PRC_STOCK_IN_UPDATE
  AFTER UPDATE
  ON MER_PRC_STOCK_IN FOR EACH ROW
BEGIN
    DECLARE VAR_CUM_ORDERS_VAL FLOAT DEFAULT 0;
    DECLARE VAR_MER_CUM_ORDERS_VAL FLOAT DEFAULT 0;

    SELECT SUM(INVOICE_TOTAL_ACTUAL_GBP),  SUM(MER_INVOICE_TOTAL_ACTUAL_GBP) INTO VAR_CUM_ORDERS_VAL, VAR_MER_CUM_ORDERS_VAL FROM MER_PRC_STOCK_IN WHERE F_MERCHANT_NO = NEW.F_MERCHANT_NO;

    UPDATE SLS_MERCHANT  SET CUM_ORDERS_VAL = VAR_CUM_ORDERS_VAL, VAR_CUM_ORDERS_VAL = VAR_MER_CUM_ORDERS_VAL WHERE PK_NO = NEW.F_MERCHANT_NO;

END



--===============================---
CREATE TRIGGER BEFORE_MER_PRC_STOCK_IN_DETAILS_INSERT
  BEFORE INSERT
  ON MER_PRC_STOCK_IN_DETAILS FOR EACH ROW
BEGIN
	declare PARENT_CODE int(11) default 0;
	declare PKCODE varchar(20) default 0;
	declare VAR_RECIEVED_QTY int(11) default 0;
	declare VAR_TOTAL_QTY int(11) default 0;
	declare VAR_FAULTY_QTY int(11) default 0;
	declare VAR_LINE_TOTAL_VAT_MR FLOAT default 0;
	declare VAR_SUB_TOTAL_MR_EV FLOAT default 0;
	declare VAR_REC_TOTAL_MR_WITH_VAT FLOAT default 0;
	declare VAR_REC_TOTAL_MR_ONLY_VAT FLOAT default 0;
	declare VAR_LINE_TOTAL_VAT_GBP FLOAT default 0;
	declare VAR_SUB_TOTAL_GBP_EV FLOAT default 0;
	declare VAR_REC_TOTAL_GBP_WITH_VAT FLOAT default 0;
	declare VAR_REC_TOTAL_GBP_ONLY_VAT FLOAT default 0;
	declare VAR_LINE_TOTAL_VAT_AC FLOAT default 0;
	declare VAR_SUB_TOTAL_AC_EV FLOAT default 0;
	declare VAR_REC_TOTAL_AC_WITH_VAT FLOAT default 0;
	declare VAR_REC_TOTAL_AC_ONLY_VAT FLOAT default 0;
    declare MER_VAR_LINE_TOTAL_VAT_MR FLOAT default 0;
    declare MER_VAR_SUB_TOTAL_MR_EV FLOAT default 0;
    declare MER_VAR_LINE_TOTAL_VAT_GBP FLOAT default 0;
    declare MER_VAR_SUB_TOTAL_GBP_EV FLOAT default 0;

	/*-----------FOR CODE---------------*/
	select CODE into PARENT_CODE
	from MER_PRC_STOCK_IN
	where PK_NO = NEW.F_PRC_STOCK_IN ;

	select IFNULL(max(CODE),0) into PKCODE
	from MER_PRC_STOCK_IN_DETAILS
	where F_PRC_STOCK_IN = NEW.F_PRC_STOCK_IN ;

	IF PKCODE = 0 THEN
		SET NEW.CODE = CONCAT(PARENT_CODE*100,PKCODE+1) ;
	ELSE
		SET NEW.CODE = PKCODE+1 ;
	END IF;
	/*-----------END CODE---------------*/

	/*-----------FOR UPDATE PRC_STOCK_IN---------------*/
	select
		IFNULL(SUM(RECIEVED_QTY),0)
		,IFNULL(SUM(QTY),0)
		,IFNULL(SUM(FAULTY_QTY),0)
		,IFNULL(SUM(LINE_TOTAL_VAT_MR),0)
		,IFNULL(SUM(SUB_TOTAL_MR_EV),0)
		,IFNULL(SUM(REC_TOTAL_MR_WITH_VAT),0)
		,IFNULL(SUM(REC_TOTAL_MR_ONLY_VAT),0)
		,IFNULL(SUM(LINE_TOTAL_VAT_GBP),0)
		,IFNULL(SUM(SUB_TOTAL_GBP_EV),0)
		,IFNULL(SUM(REC_TOTAL_GBP_WITH_VAT),0)
		,IFNULL(SUM(REC_TOTAL_GBP_ONLY_VAT),0)
		,IFNULL(SUM(LINE_TOTAL_VAT_AC),0)
		,IFNULL(SUM(SUB_TOTAL_AC_EV),0)
		,IFNULL(SUM(REC_TOTAL_AC_WITH_VAT),0)
		,IFNULL(SUM(REC_TOTAL_AC_ONLY_VAT),0)
        ,IFNULL(SUM(MER_LINE_TOTAL_VAT_MR),0)
        ,IFNULL(SUM(MER_SUB_TOTAL_MR_EV),0)
        ,IFNULL(SUM(MER_LINE_TOTAL_VAT_GBP),0)
        ,IFNULL(SUM(MER_SUB_TOTAL_GBP_EV),0)
	INTO
		VAR_RECIEVED_QTY
		,VAR_TOTAL_QTY
		,VAR_FAULTY_QTY
		,VAR_LINE_TOTAL_VAT_MR
		,VAR_SUB_TOTAL_MR_EV
		,VAR_REC_TOTAL_MR_WITH_VAT
		,VAR_REC_TOTAL_MR_ONLY_VAT
		,VAR_LINE_TOTAL_VAT_GBP
		,VAR_SUB_TOTAL_GBP_EV
		,VAR_REC_TOTAL_GBP_WITH_VAT
		,VAR_REC_TOTAL_GBP_ONLY_VAT
		,VAR_LINE_TOTAL_VAT_AC
		,VAR_SUB_TOTAL_AC_EV
		,VAR_REC_TOTAL_AC_WITH_VAT
		,VAR_REC_TOTAL_AC_ONLY_VAT
        ,MER_VAR_LINE_TOTAL_VAT_MR
        ,MER_VAR_SUB_TOTAL_MR_EV
        ,MER_VAR_LINE_TOTAL_VAT_GBP
        ,MER_VAR_SUB_TOTAL_GBP_EV
	from MER_PRC_STOCK_IN_DETAILS
	where F_PRC_STOCK_IN = NEW.F_PRC_STOCK_IN ;

	UPDATE MER_PRC_STOCK_IN
		SET
			RECIEVED_QTY 					= VAR_RECIEVED_QTY+NEW.RECIEVED_QTY
			,TOTAL_QTY 						= VAR_TOTAL_QTY+NEW.QTY
			,FAULTY_QTY 					= VAR_FAULTY_QTY+NEW.FAULTY_QTY

			,INVOICE_TOTAL_VAT_ACTUAL_MR 	= VAR_LINE_TOTAL_VAT_MR+NEW.LINE_TOTAL_VAT_MR
			,INVOICE_TOTAL_EV_ACTUAL_MR 	= VAR_SUB_TOTAL_MR_EV+NEW.SUB_TOTAL_MR_EV
			,INVOICE_TOTAL_ACTUAL_MR 		= VAR_LINE_TOTAL_VAT_MR+NEW.LINE_TOTAL_VAT_MR+VAR_SUB_TOTAL_MR_EV+NEW.SUB_TOTAL_MR_EV
			,INVOICE_REC_TOTAL_ACTUAL_MR_WITH_VAT 	= VAR_REC_TOTAL_MR_WITH_VAT+NEW.REC_TOTAL_MR_WITH_VAT
			,INVOICE_REC_TOTAL_ACTUAL_MR_ONLY_VAT 	= VAR_REC_TOTAL_MR_ONLY_VAT+NEW.REC_TOTAL_MR_ONLY_VAT

			,INVOICE_TOTAL_VAT_ACTUAL_GBP 	= VAR_LINE_TOTAL_VAT_GBP+NEW.LINE_TOTAL_VAT_GBP
			,INVOICE_TOTAL_EV_ACTUAL_GBP 	= VAR_SUB_TOTAL_GBP_EV+NEW.SUB_TOTAL_GBP_EV
			,INVOICE_TOTAL_ACTUAL_GBP 		= VAR_LINE_TOTAL_VAT_GBP+NEW.LINE_TOTAL_VAT_GBP+VAR_SUB_TOTAL_GBP_EV+NEW.SUB_TOTAL_GBP_EV
			,INVOICE_REC_TOTAL_ACTUAL_GBP_WITH_VAT 		= VAR_REC_TOTAL_GBP_WITH_VAT+NEW.REC_TOTAL_GBP_WITH_VAT
			,INVOICE_REC_TOTAL_ACTUAL_GBP_ONLY_VAT 		= VAR_REC_TOTAL_GBP_ONLY_VAT+NEW.REC_TOTAL_GBP_ONLY_VAT

			,INVOICE_TOTAL_VAT_ACTUAL_AC 	= VAR_LINE_TOTAL_VAT_AC+NEW.LINE_TOTAL_VAT_AC
			,INVOICE_TOTAL_EV_ACTUAL_AC 	= VAR_SUB_TOTAL_AC_EV+NEW.SUB_TOTAL_AC_EV
			,INVOICE_TOTAL_ACTUAL_AC 		= VAR_LINE_TOTAL_VAT_AC+NEW.LINE_TOTAL_VAT_AC+VAR_SUB_TOTAL_AC_EV+NEW.SUB_TOTAL_AC_EV
			,INVOICE_REC_TOTAL_ACTUAL_AC_WITH_VAT 		= VAR_REC_TOTAL_AC_WITH_VAT+NEW.REC_TOTAL_AC_WITH_VAT
			,INVOICE_REC_TOTAL_ACTUAL_AC_ONLY_VAT 		= VAR_REC_TOTAL_AC_ONLY_VAT+NEW.REC_TOTAL_AC_ONLY_VAT
            ,MER_INVOICE_TOTAL_ACTUAL_MR 		= MER_VAR_LINE_TOTAL_VAT_MR+NEW.MER_LINE_TOTAL_VAT_MR+MER_VAR_SUB_TOTAL_MR_EV+NEW.MER_SUB_TOTAL_MR_EV
            ,MER_INVOICE_TOTAL_ACTUAL_GBP 		= MER_VAR_LINE_TOTAL_VAT_GBP+NEW.MER_LINE_TOTAL_VAT_GBP+MER_VAR_SUB_TOTAL_GBP_EV+NEW.MER_SUB_TOTAL_GBP_EV


	WHERE PK_NO = NEW.F_PRC_STOCK_IN;
	/*-----------END UPDATE PRC_STOCK_IN---------------*/


END

--=========================--
CREATE TRIGGER AFTER_MER_PRC_STOCK_IN_DETAILS_DELETE
  AFTER DELETE
  ON MER_PRC_STOCK_IN_DETAILS FOR EACH ROW
BEGIN


	UPDATE MER_PRC_STOCK_IN
		SET
			RECIEVED_QTY 					= RECIEVED_QTY-OLD.RECIEVED_QTY
			,TOTAL_QTY 						= TOTAL_QTY-OLD.QTY
			,FAULTY_QTY 					= FAULTY_QTY-OLD.FAULTY_QTY

			,INVOICE_TOTAL_VAT_ACTUAL_MR 	= INVOICE_TOTAL_VAT_ACTUAL_MR-OLD.LINE_TOTAL_VAT_MR
			,INVOICE_TOTAL_EV_ACTUAL_MR 	= INVOICE_TOTAL_EV_ACTUAL_MR-OLD.SUB_TOTAL_MR_EV
			,INVOICE_TOTAL_ACTUAL_MR 		= INVOICE_TOTAL_ACTUAL_MR-(OLD.LINE_TOTAL_VAT_MR+OLD.SUB_TOTAL_MR_EV)
			,INVOICE_REC_TOTAL_ACTUAL_MR_WITH_VAT = INVOICE_REC_TOTAL_ACTUAL_MR_WITH_VAT - OLD.REC_TOTAL_MR_WITH_VAT
			,INVOICE_REC_TOTAL_ACTUAL_MR_ONLY_VAT = INVOICE_REC_TOTAL_ACTUAL_MR_ONLY_VAT - OLD.REC_TOTAL_MR_ONLY_VAT

			,INVOICE_TOTAL_VAT_ACTUAL_GBP 	= INVOICE_TOTAL_VAT_ACTUAL_GBP-OLD.LINE_TOTAL_VAT_GBP
			,INVOICE_TOTAL_EV_ACTUAL_GBP 	= INVOICE_TOTAL_EV_ACTUAL_GBP-OLD.SUB_TOTAL_GBP_EV
			,INVOICE_TOTAL_ACTUAL_GBP 		= INVOICE_TOTAL_ACTUAL_GBP-(OLD.LINE_TOTAL_VAT_GBP+OLD.SUB_TOTAL_GBP_EV)
			,INVOICE_REC_TOTAL_ACTUAL_GBP_WITH_VAT = INVOICE_REC_TOTAL_ACTUAL_GBP_WITH_VAT - OLD.REC_TOTAL_GBP_WITH_VAT
			,INVOICE_REC_TOTAL_ACTUAL_GBP_ONLY_VAT = INVOICE_REC_TOTAL_ACTUAL_GBP_ONLY_VAT - OLD.REC_TOTAL_GBP_ONLY_VAT

			,INVOICE_TOTAL_VAT_ACTUAL_AC 	= INVOICE_TOTAL_VAT_ACTUAL_AC-OLD.LINE_TOTAL_VAT_AC
			,INVOICE_TOTAL_EV_ACTUAL_AC 	= INVOICE_TOTAL_EV_ACTUAL_AC-OLD.SUB_TOTAL_AC_EV
			,INVOICE_TOTAL_ACTUAL_AC 		= INVOICE_TOTAL_ACTUAL_AC-(OLD.LINE_TOTAL_VAT_AC+OLD.SUB_TOTAL_AC_EV)
			,INVOICE_REC_TOTAL_ACTUAL_AC_WITH_VAT = INVOICE_REC_TOTAL_ACTUAL_AC_WITH_VAT - OLD.REC_TOTAL_AC_WITH_VAT
			,INVOICE_REC_TOTAL_ACTUAL_AC_ONLY_VAT = INVOICE_REC_TOTAL_ACTUAL_AC_ONLY_VAT - OLD.REC_TOTAL_AC_ONLY_VAT

            ,MER_INVOICE_TOTAL_ACTUAL_GBP 		= MER_INVOICE_TOTAL_ACTUAL_GBP-(OLD.MER_LINE_TOTAL_VAT_GBP+OLD.MER_SUB_TOTAL_GBP_EV)
            ,MER_INVOICE_TOTAL_ACTUAL_MR 		= MER_INVOICE_TOTAL_ACTUAL_MR-(OLD.MER_LINE_TOTAL_VAT_MR+OLD.MER_SUB_TOTAL_MR_EV)


	WHERE PK_NO = OLD.F_PRC_STOCK_IN;

END

--=============================---
CREATE TRIGGER BEFORE_SLS_MERCHANT_INSERT
  BEFORE INSERT
  ON SLS_MERCHANT FOR EACH ROW
BEGIN

declare VAR_MERCHANT_NO int(11) default 0;

SELECT IFNULL(MAX(MERCHANT_NO),100) AS SMERCHANT_NO INTO  VAR_MERCHANT_NO FROM SLS_MERCHANT;

    SET NEW.MERCHANT_NO = VAR_MERCHANT_NO+1;

END


--==========================-----
CREATE TRIGGER BEFORE_MER_INV_STOCK_PRC_STOCK_IN_MAP_INSERT
  BEFORE INSERT
  ON MER_INV_STOCK_PRC_STOCK_IN_MAP FOR EACH ROW
BEGIN

    SET NEW.IS_PROCESS_COMPLETE = 0 ;
    SET NEW.PROCESS_START_TIME = NOW() ;


END

--==========================-----
CREATE TRIGGER AFTER_MER_INV_STOCK_PRC_STOCK_IN_MAP_INSERT
  AFTER INSERT
  ON MER_INV_STOCK_PRC_STOCK_IN_MAP FOR EACH ROW
BEGIN

    CALL  PROC_MER_INV_STOCK_PRC_STOCK_IN_MAP(NEW.PK_NO);

    UPDATE MER_PRC_STOCK_IN
    SET INV_STOCK_RECORD_GENERATED = 1
    WHERE PK_NO = NEW.F_PRC_STOCK_IN_NO;
END



--==========================-----
CREATE TRIGGER AFTER_ACC_MERCHANT_PAYMENTS_INSERT
  AFTER INSERT
  ON ACC_MERCHANT_PAYMENTS FOR EACH ROW
BEGIN
    declare VAR_CUM_BALANCE FLOAT default 0;
    declare VAR_CUSTOMER_BALANCE_BUFFER FLOAT default 0;

SELECT IFNULL(SUM(PAYMENT_REMAINING_MR),0), IFNULL(SUM(MR_AMOUNT),0)
INTO VAR_CUM_BALANCE, VAR_CUSTOMER_BALANCE_BUFFER FROM ACC_MERCHANT_PAYMENTS WHERE F_MERCHANT_NO = NEW.F_MERCHANT_NO;

    UPDATE SLS_MERCHANT SET CUM_BALANCE = VAR_CUM_BALANCE,
    CUSTOMER_BALANCE_BUFFER = VAR_CUSTOMER_BALANCE_BUFFER,
    CUSTOMER_BALANCE_ACTUAL = VAR_CUSTOMER_BALANCE_BUFFER
    WHERE PK_NO = NEW.F_MERCHANT_NO;

END

CREATE TRIGGER AFTER_ACC_MERCHANT_PAYMENTS_UPDATE
  AFTER UPDATE
  ON ACC_MERCHANT_PAYMENTS FOR EACH ROW
BEGIN
    declare VAR_CUM_BALANCE FLOAT default 0;
    declare VAR_CUSTOMER_BALANCE_BUFFER FLOAT default 0;

SELECT IFNULL(SUM(PAYMENT_REMAINING_MR),0), IFNULL(SUM(MR_AMOUNT),0)
INTO VAR_CUM_BALANCE, VAR_CUSTOMER_BALANCE_BUFFER FROM ACC_MERCHANT_PAYMENTS WHERE F_MERCHANT_NO = NEW.F_MERCHANT_NO;

    UPDATE SLS_MERCHANT SET CUM_BALANCE = VAR_CUM_BALANCE,
    CUSTOMER_BALANCE_BUFFER = VAR_CUSTOMER_BALANCE_BUFFER,
    CUSTOMER_BALANCE_ACTUAL = VAR_CUSTOMER_BALANCE_BUFFER
    WHERE PK_NO = NEW.F_MERCHANT_NO;

END




















































































--=============PROC===============---
CREATE PROCEDURE PROC_MER_INV_STOCK_PRC_STOCK_IN_MAP(IN_PK_NO Integer)
  NO SQL

BEGIN

/*PROC_INV_STOCK_PRC_STOCK_IN_MAP*/
    DECLARE int_F_PRC_STOCK_IN_NO INT(11) default 0;
    DECLARE int_F_INV_WAREHOUSE_NO INT(11) default 0;

    /* INV_WAREHOUSE_NAME variable DECLARE*/
    DECLARE VAR_INV_WAREHOUSE_NAME  varchar(200);

    /*PRC_STOCK_IN_DETAILS*/
    DECLARE int_HAS_DATA_PRC_STOCK_IN_DETAILS INT DEFAULT 1;
    DECLARE int_RECIEVED_QTY INT;
    DECLARE int_FAULTY_QTY INT;
    DECLARE int_TOTAL INT;

    /*INV STOCK*/
    DECLARE xCODE                            INT;
    DECLARE xF_INV_STOCK_PRC_STOCK_IN_MAP_NO INT;
    DECLARE xF_PRC_STOCK_IN_NO               INT;
    DECLARE xF_PRC_STOCK_IN_DETAILS_NO       INT;
    DECLARE xIG_CODE                         varchar(20);
    DECLARE xSKUID                           varchar(40);
    DECLARE xF_PRD_VARIANT_NO                INT;
    DECLARE xPRD_VARINAT_NAME                varchar(200);
    DECLARE xINVOICE_NAME                    varchar(200);
    DECLARE xF_INV_WAREHOUSE_NO              INT;
    DECLARE xINV_WAREHOUSE_NAME              varchar(200);
    DECLARE xF_BOOKING_NO                    INT;
    DECLARE xF_BOOKING_DETAILS_NO            INT;
    DECLARE xF_ORDER_NO                      INT;
    DECLARE xF_ORDER_DETAILS_NO              INT;
    DECLARE xHS_CODE                         varchar(20);
    DECLARE xHS_CODE_NARRATION               varchar(200);
    DECLARE xF_CATEGORY_NO                   INT;
    DECLARE xCATEGORY_NAME                   varchar(200);
    DECLARE xF_SUB_CATEGORY_NO               INT;
    DECLARE xSUB_CATEGORY_NAME               varchar(200);
    DECLARE xBARCODE                         varchar(40);
    DECLARE xF_BRAND_NO                      INT;
    DECLARE xBRAND_NAME                      varchar(40);
    DECLARE xF_MODEL_NO                      INT;
    DECLARE xMODEL_NAME                      varchar(200);
    DECLARE xPRODUCT_STATUS                  INT;
    DECLARE xBOOKING_STATUS                  INT;
    DECLARE xORDER_STATUS                    INT;
    DECLARE xPRODUCT_PURCHASE_PRICE_GBP      FLOAT;
    DECLARE xPRODUCT_PURCHASE_PRICE          FLOAT;
     DECLARE xMER_PRODUCT_PURCHASE_PRICE_GBP      FLOAT;
    DECLARE xMER_PRODUCT_PURCHASE_PRICE          FLOAT;
    DECLARE xPRODUCT_REGULAR_PRICE           FLOAT;
    DECLARE xPRODUCT_INSTALLMENT_PRICE       FLOAT;
    DECLARE xORDER_PRICE                     FLOAT;
    DECLARE xSS_COST                         FLOAT;
    DECLARE xSM_COST                         FLOAT;
    DECLARE xAIR_FREIGHT_COST                FLOAT;
    DECLARE xSEA_FREIGHT_COST                FLOAT;
    DECLARE xPREFERRED_SHIPPING_METHOD       varchar(40);
    DECLARE xF_SHIPPMENT_NO                  INT;
    DECLARE xSHIPMENT_NAME                   varchar(200);
    DECLARE xBOX_BARCODE                     varchar(200);
    DECLARE xF_BOX_NO                        INT;
    DECLARE xPRC_IN_IMAGE_PATH               varchar(200);
    DECLARE xPRD_VARIANT_IMAGE_PATH          varchar(200);
    DECLARE xF_MERCHANT_NO                   INT;

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
                        ,PRODUCT.VARIANT_NAME
                        ,INVOICE.INVOICE_NAME
                        ,PRODUCT.HS_CODE
                        ,PRODUCT.BARCODE
                        ,INVOICE.UNIT_PRICE_GBP_EV
                        ,INVOICE.UNIT_PRICE_MR_EV
                        ,INVOICE.MER_UNIT_PRICE_GBP_EV
                        ,INVOICE.MER_UNIT_PRICE_MR_EV
                        ,INVOICE.RECIEVED_QTY
                        ,INVOICE.FAULTY_QTY
                        ,PRODUCT.REGULAR_PRICE
                        ,PRODUCT.INSTALLMENT_PRICE
                        ,PRODUCT.INTER_DISTRICT_POSTAGE
                        ,PRODUCT.LOCAL_POSTAGE
                        ,PRODUCT.AIR_FREIGHT_CHARGE
                        ,PRODUCT.SEA_FREIGHT_CHARGE
                        ,PRODUCT.PREFERRED_SHIPPING_METHOD
                        ,INVOICE_MASTER.MASTER_INVOICE_RELATIVE_PATH
                        ,PRODUCT.PRIMARY_IMG_RELATIVE_PATH
                        ,PRODUCT_MASTER.F_MODEL
                        ,PRODUCT_MASTER.MODEL_NAME
                        ,PRODUCT_MASTER.F_BRAND
                        ,PRODUCT_MASTER.BRAND_NAME
                        ,PRODUCT_SUB_CATEGORY.PK_NO
                        ,PRODUCT_SUB_CATEGORY.NAME
                        ,PRODUCT_CATEGORY.PK_NO
                        ,PRODUCT_CATEGORY.NAME
                        ,INVOICE_MASTER.F_MERCHANT_NO


                        FROM
                                MER_PRC_STOCK_IN INVOICE_MASTER
                                ,MER_PRC_STOCK_IN_DETAILS INVOICE
                                ,PRD_VARIANT_SETUP PRODUCT
                                ,PRD_MASTER_SETUP PRODUCT_MASTER
                                ,PRD_SUB_CATEGORY PRODUCT_SUB_CATEGORY
                                ,PRD_CATEGORY PRODUCT_CATEGORY


                        WHERE
                            INVOICE.F_PRC_STOCK_IN = int_F_PRC_STOCK_IN_NO
                        AND INVOICE.F_PRD_VARIANT_NO = PRODUCT.PK_NO
                        AND PRODUCT.F_PRD_MASTER_SETUP_NO=  PRODUCT_MASTER.PK_NO
                        AND PRODUCT_MASTER.F_PRD_SUB_CATEGORY_ID= PRODUCT_SUB_CATEGORY.PK_NO
                        AND PRODUCT_SUB_CATEGORY.F_PRD_CATEGORY_NO=  PRODUCT_CATEGORY.PK_NO
                        AND INVOICE_MASTER.PK_NO = INVOICE.F_PRC_STOCK_IN
                            ;



    DECLARE CONTINUE HANDLER
    FOR NOT FOUND SET int_HAS_DATA_PRC_STOCK_IN_DETAILS=0;


    /*delete from R;
    insert into R values ('96');

    insert into R values (int_F_PRC_STOCK_IN_NO);
    insert into R values (int_F_INV_WAREHOUSE_NO);    */


    SELECT F_PRC_STOCK_IN_NO ,F_INV_WAREHOUSE_NO
        INTO int_F_PRC_STOCK_IN_NO, int_F_INV_WAREHOUSE_NO
    FROM MER_INV_STOCK_PRC_STOCK_IN_MAP
    WHERE PK_NO = IN_PK_NO ;


    /*FOR INV_WAREHOUSE_NAME  */

    SELECT NAME
        INTO VAR_INV_WAREHOUSE_NAME
    FROM INV_WAREHOUSE
    WHERE PK_NO = int_F_INV_WAREHOUSE_NO;

    IF int_F_INV_WAREHOUSE_NO = 2 THEN
       SET xPRODUCT_STATUS = 60;
    ELSE
       SET xPRODUCT_STATUS = NULL;
    END IF;
    /*insert into R values (int_F_PRC_STOCK_IN_NO);
    insert into R values (int_F_INV_WAREHOUSE_NO);        */


    OPEN cur_PRC_STOCK_IN_DETAILS;

        insert into R values ('105');

                get_PRC_STOCK_IN_DETAILS:LOOP

                        FETCH NEXT FROM  cur_PRC_STOCK_IN_DETAILS INTO

                        xF_PRC_STOCK_IN_NO               ,
                        xF_PRC_STOCK_IN_DETAILS_NO       ,
                        xF_PRD_VARIANT_NO                ,
                        xIG_CODE                         ,
                        xSKUID                           ,
                        xPRD_VARINAT_NAME                ,
                        xINVOICE_NAME                    ,
                        xHS_CODE                         ,
                        xBARCODE                         ,
                        xPRODUCT_PURCHASE_PRICE_GBP      ,
                        xPRODUCT_PURCHASE_PRICE          ,
                        xMER_PRODUCT_PURCHASE_PRICE_GBP  ,
                        xMER_PRODUCT_PURCHASE_PRICE      ,
                        int_RECIEVED_QTY                 ,
                        int_FAULTY_QTY                   ,
                        xPRODUCT_REGULAR_PRICE           ,
                        xPRODUCT_INSTALLMENT_PRICE       ,
                        xSS_COST                         ,
                        xSM_COST                         ,
                        xAIR_FREIGHT_COST                ,
                        xSEA_FREIGHT_COST                ,
                        xPREFERRED_SHIPPING_METHOD       ,
                        xPRC_IN_IMAGE_PATH               ,
                        xPRD_VARIANT_IMAGE_PATH          ,
                        xF_MODEL_NO                      ,
                        xMODEL_NAME                      ,
                        xF_BRAND_NO                      ,
                        xBRAND_NAME                      ,
                        xF_SUB_CATEGORY_NO               ,
                        xSUB_CATEGORY_NAME               ,
                        xF_CATEGORY_NO                   ,
                        xCATEGORY_NAME                   ,
                        xF_MERCHANT_NO                   ;


        /*TOTAL GEN = RECQTY - FAUTLY QTY*/
        IF int_HAS_DATA_PRC_STOCK_IN_DETAILS = 0 THEN
            LEAVE get_PRC_STOCK_IN_DETAILS;

        END IF;

        SET int_TOTAL = int_RECIEVED_QTY - int_FAULTY_QTY;

        SET i=0;
        WHILE i < int_TOTAL DO

            insert into MER_INV_STOCK(
                F_INV_STOCK_PRC_STOCK_IN_MAP_NO
                ,F_PRC_STOCK_IN_NO
                ,F_PRC_STOCK_IN_DETAILS_NO
                ,IG_CODE
                ,SKUID
                ,F_PRD_VARIANT_NO
                ,PRD_VARINAT_NAME
                ,INVOICE_NAME
                ,F_INV_WAREHOUSE_NO
                ,INV_WAREHOUSE_NAME
                ,HS_CODE
                ,F_CATEGORY_NO
                ,CATEGORY_NAME
                ,F_SUB_CATEGORY_NO
                ,SUB_CATEGORY_NAME
                ,BARCODE
                ,F_BRAND_NO
                ,BRAND_NAME
                ,F_MODEL_NO
                ,MODEL_NAME
                ,PRODUCT_PURCHASE_PRICE_GBP
                ,PRODUCT_PURCHASE_PRICE
                ,MER_PRODUCT_PURCHASE_PRICE_GBP
                ,MER_PRODUCT_PURCHASE_PRICE
                ,REGULAR_PRICE
                ,INSTALLMENT_PRICE
                ,SS_COST
                ,SM_COST
                ,AIR_FREIGHT_COST
                ,SEA_FREIGHT_COST
                ,PREFERRED_SHIPPING_METHOD
                ,FINAL_PREFFERED_SHIPPING_METHOD
                ,PRC_IN_IMAGE_PATH
                ,PRD_VARIANT_IMAGE_PATH
                ,PRODUCT_STATUS
                ,F_MERCHANT_NO
                )
            VALUES

            (

            IN_PK_NO
            ,xF_PRC_STOCK_IN_NO
            ,xF_PRC_STOCK_IN_DETAILS_NO
            ,xIG_CODE
            ,xSKUID
            ,xF_PRD_VARIANT_NO
            ,xPRD_VARINAT_NAME
            ,xINVOICE_NAME
            ,int_F_INV_WAREHOUSE_NO
            ,VAR_INV_WAREHOUSE_NAME
            ,xHS_CODE
            ,xF_CATEGORY_NO
            ,xCATEGORY_NAME
            ,xF_SUB_CATEGORY_NO
            ,xSUB_CATEGORY_NAME
            ,xBARCODE
            ,xF_BRAND_NO
            ,xBRAND_NAME
            ,xF_MODEL_NO
            ,xMODEL_NAME
            ,xPRODUCT_PURCHASE_PRICE_GBP
            ,xPRODUCT_PURCHASE_PRICE
            ,xMER_PRODUCT_PURCHASE_PRICE_GBP
            ,xMER_PRODUCT_PURCHASE_PRICE
            ,xPRODUCT_REGULAR_PRICE
            ,xPRODUCT_INSTALLMENT_PRICE
            ,xSS_COST
            ,xSM_COST
            ,xAIR_FREIGHT_COST
            ,xSEA_FREIGHT_COST
            ,xPREFERRED_SHIPPING_METHOD
            ,xPREFERRED_SHIPPING_METHOD
            ,xPRC_IN_IMAGE_PATH
            ,xPRD_VARIANT_IMAGE_PATH
            ,xPRODUCT_STATUS
            ,xF_MERCHANT_NO
                );

            SET i = i + 1;

        END WHILE;

    END LOOP get_PRC_STOCK_IN_DETAILS;

CLOSE cur_PRC_STOCK_IN_DETAILS;

END


CREATE TRIGGER BEFORE_ACC_PAYMENT_BANK_ACC_INSERT
  BEFORE INSERT
  ON ACC_PAYMENT_BANK_ACC FOR EACH ROW
BEGIN
declare PKCODE int(11) default 0;

select IFNULL(max(CODE),100) into PKCODE
from ACC_PAYMENT_BANK_ACC;
SET NEW.CODE = PKCODE+1 ;
END





DELIMITER $$

USE `easybazardb`$$

DROP TRIGGER `BEFORE_ACC_PAYMENT_BANK_ACC_INSERT`$$

CREATE
    /*!50017 DEFINER = 'root'@'localhost' */
    TRIGGER `BEFORE_ACC_PAYMENT_BANK_ACC_INSERT` BEFORE INSERT ON `ACC_PAYMENT_BANK_ACC`
    FOR EACH ROW BEGIN
declare PKCODE int(11) default 0;
select IFNULL(max(CODE),100) into PKCODE
from ACC_PAYMENT_BANK_ACC;
SET NEW.CODE = PKCODE+1 ;


END;
$$

DELIMITER ;








