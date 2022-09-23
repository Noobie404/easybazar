CREATE PROCEDURE PROC_CUSTOMER_PAYMENT(IN_PK_NO Integer(11), IN_TYPE VarChar(20))
  NO SQL
BEGIN

   -- INSET A NEW ENTRY IN ACC_BANK_TXN
    -- UPDATE ACC_PAYMENT_BANK_ACC BALACNE_BUFFER (INCREMENT)
    -- UPDATE SLS_CUSTOMERS CUSTOMER_BALANCE_BUFFER (INCREMENT)

        DECLARE VAR_ACC_CUSTOMER_PAYMENTS_PK_NO INT DEFAULT 0;
        DECLARE VAR_F_CUSTOMER_NO INT DEFAULT 0;
        DECLARE VAR_F_PAYMENT_ACC_NO INT DEFAULT 0;
        DECLARE VAR_ACC_MERCHANT_PAYMENTS_PK_NO INT DEFAULT 0;
        DECLARE VAR_F_SS_CREATED_BY INT DEFAULT 0;
        DECLARE VAR_IS_MATCHED INT DEFAULT 0;
        DECLARE VAR_MR_AMOUNT FLOAT DEFAULT 0;     
        DECLARE VAR_PAYMENT_REMAINING_MR FLOAT DEFAULT 0;
        DECLARE VAR_AMOUNT_ACTUAL FLOAT DEFAULT 0;
        DECLARE VAR_PAYMENT_TYPE FLOAT DEFAULT 1;
        DECLARE VAR_TOTAL_PAYMENT_REMAINING_MR FLOAT DEFAULT 0;
        DECLARE VAR_PAYMENT_DATE DATE DEFAULT NULL;
        DECLARE VAR_CUM_BALANCE FLOAT DEFAULT 0;
        DECLARE VAR_CUSTOMER_BALANCE_ACTUAL FLOAT DEFAULT 0;



        IF IN_TYPE = 'customer' THEN


            SELECT PK_NO, F_CUSTOMER_NO,F_PAYMENT_ACC_NO,MR_AMOUNT,PAYMENT_DATE,F_SS_CREATED_BY,PAYMENT_TYPE,PAYMENT_REMAINING_MR INTO VAR_ACC_CUSTOMER_PAYMENTS_PK_NO, VAR_F_CUSTOMER_NO, VAR_F_PAYMENT_ACC_NO, VAR_MR_AMOUNT, VAR_PAYMENT_DATE,VAR_F_SS_CREATED_BY,VAR_PAYMENT_TYPE,VAR_PAYMENT_REMAINING_MR FROM ACC_CUSTOMER_PAYMENTS WHERE PK_NO = IN_PK_NO;

             IF VAR_PAYMENT_TYPE = 3 THEN
                SET VAR_IS_MATCHED = 1;
                SET VAR_AMOUNT_ACTUAL = VAR_MR_AMOUNT;
             END IF;
             IF VAR_PAYMENT_TYPE = 4 THEN
                SET VAR_IS_MATCHED = 1;
                SET VAR_AMOUNT_ACTUAL = VAR_MR_AMOUNT;
             END IF;

            INSERT INTO ACC_BANK_TXN(TXN_REF, TXN_TYPE_IN_OUT, TXN_DATE,AMOUNT_ACTUAL, AMOUNT_BUFFER, IS_CUS_SELLER_BANK_RECONCILATION, F_ACC_PAYMENT_BANK_NO, F_CUSTOMER_NO, F_CUSTOMER_PAYMENT_NO,F_SS_CREATED_BY,SS_CREATED_ON,PAYMENT_TYPE,IS_MATCHED)
                VALUES(NULL, 1, VAR_PAYMENT_DATE,VAR_AMOUNT_ACTUAL, VAR_MR_AMOUNT, 1, VAR_F_PAYMENT_ACC_NO, VAR_F_CUSTOMER_NO,VAR_ACC_CUSTOMER_PAYMENTS_PK_NO,VAR_F_SS_CREATED_BY,NOW(),VAR_PAYMENT_TYPE,VAR_IS_MATCHED);

            IF VAR_PAYMENT_TYPE = 3 THEN
                UPDATE ACC_PAYMENT_BANK_ACC
                SET BALACNE_BUFFER = IFNULL(BALACNE_BUFFER,0)  + VAR_MR_AMOUNT
                ,BALANCE_ACTUAL = IFNULL(BALANCE_ACTUAL,0)  + VAR_MR_AMOUNT
                WHERE PK_NO = VAR_F_PAYMENT_ACC_NO;

                UPDATE SLS_CUSTOMERS
                SET CUSTOMER_BALANCE_BUFFER = IFNULL(CUSTOMER_BALANCE_BUFFER,0)  + VAR_MR_AMOUNT
                ,CUSTOMER_BALANCE_ACTUAL = IFNULL(CUSTOMER_BALANCE_ACTUAL,0)  + VAR_MR_AMOUNT
                ,CUM_BALANCE = IFNULL(CUM_BALANCE,0)  + VAR_MR_AMOUNT
                WHERE PK_NO = VAR_F_CUSTOMER_NO;

            ELSEIF VAR_PAYMENT_TYPE = 2 THEN
                UPDATE ACC_PAYMENT_BANK_ACC
                SET BALACNE_BUFFER = IFNULL(BALACNE_BUFFER,0)  + VAR_MR_AMOUNT
                ,BALANCE_ACTUAL = IFNULL(BALANCE_ACTUAL,0)  + VAR_MR_AMOUNT
                WHERE PK_NO = VAR_F_PAYMENT_ACC_NO;

                UPDATE SLS_CUSTOMERS
                SET CUSTOMER_BALANCE_BUFFER = IFNULL(CUSTOMER_BALANCE_BUFFER,0)  + VAR_MR_AMOUNT
                ,CUSTOMER_BALANCE_ACTUAL = IFNULL(CUSTOMER_BALANCE_ACTUAL,0)  + VAR_MR_AMOUNT
                ,CUM_BALANCE = IFNULL(CUM_BALANCE,0)  + VAR_MR_AMOUNT
                WHERE PK_NO = VAR_F_CUSTOMER_NO;

            ELSEIF VAR_PAYMENT_TYPE = 1 THEN
                UPDATE ACC_PAYMENT_BANK_ACC
                SET BALACNE_BUFFER = IFNULL(BALACNE_BUFFER,0)  + VAR_MR_AMOUNT
                WHERE PK_NO = VAR_F_PAYMENT_ACC_NO;

                UPDATE SLS_CUSTOMERS
                SET CUSTOMER_BALANCE_BUFFER = IFNULL(CUSTOMER_BALANCE_BUFFER,0)  + VAR_MR_AMOUNT
                WHERE PK_NO = VAR_F_CUSTOMER_NO;

            ELSEIF VAR_PAYMENT_TYPE = 4 THEN
                UPDATE ACC_PAYMENT_BANK_ACC
                SET BALACNE_BUFFER = IFNULL(BALACNE_BUFFER,0)  + VAR_MR_AMOUNT
                ,BALANCE_ACTUAL = IFNULL(BALANCE_ACTUAL,0)  + VAR_MR_AMOUNT
                WHERE PK_NO = VAR_F_PAYMENT_ACC_NO;

                UPDATE SLS_CUSTOMERS
                SET CUSTOMER_BALANCE_BUFFER = IFNULL(CUSTOMER_BALANCE_BUFFER,0)  + VAR_MR_AMOUNT
                ,CUSTOMER_BALANCE_ACTUAL = IFNULL(CUSTOMER_BALANCE_ACTUAL,0)  + VAR_MR_AMOUNT   
                ,CUM_BALANCE = IFNULL(CUM_BALANCE,0)  + VAR_PAYMENT_REMAINING_MR
                WHERE PK_NO = VAR_F_CUSTOMER_NO;

            END IF;







END
/
