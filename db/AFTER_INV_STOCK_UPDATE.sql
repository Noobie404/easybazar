CREATE TRIGGER AFTER_INV_STOCK_UPDATE
  AFTER UPDATE
  ON INV_STOCK FOR EACH ROW
BEGIN
declare VAR_TOTAL_FREE_STOCK int(8) default 0;
declare VAR_TOTAL_STOCK int(8) default 0;
declare VAR_ROWCOUNT int(8) default 0;


SELECT COUNT(*) AS TOTAL_FREE_STOCK INTO VAR_TOTAL_FREE_STOCK FROM INV_STOCK
WHERE F_BOOKING_NO IS NULL AND F_SHOP_NO = NEW.F_SHOP_NO AND F_PRD_VARIANT_NO = NEW.F_PRD_VARIANT_NO;

SELECT COUNT(*) AS TOTAL_FREE_STOCK INTO VAR_TOTAL_STOCK FROM INV_STOCK
WHERE F_SHOP_NO = NEW.F_SHOP_NO AND F_PRD_VARIANT_NO = NEW.F_PRD_VARIANT_NO;


SELECT COUNT(*) INTO VAR_ROWCOUNT FROM PRD_VARIANT_STOCK_QTY WHERE F_PRD_VARIANT_NO = NEW.F_PRD_VARIANT_NO AND F_SHOP_NO = NEW.F_SHOP_NO;

IF VAR_ROWCOUNT > 0 THEN
   UPDATE PRD_VARIANT_STOCK_QTY SET TOTAL_STOCK = VAR_TOTAL_STOCK, TOTAL_FREE_STOCK = VAR_TOTAL_FREE_STOCK WHERE F_PRD_VARIANT_NO = NEW.F_PRD_VARIANT_NO AND F_SHOP_NO = NEW.F_SHOP_NO;

ELSE

INSERT INTO PRD_VARIANT_STOCK_QTY (F_PRD_MASTER_SETUP_NO, F_PRD_VARIANT_NO, F_SHOP_NO, TOTAL_FREE_STOCK, TOTAL_STOCK,  IS_ACTIVE)
 VALUES ( NEW.F_PRD_MASTER_SETUP_NO, NEW.F_PRD_VARIANT_NO, NEW.F_SHOP_NO, VAR_TOTAL_FREE_STOCK, VAR_TOTAL_STOCK, 1);
END IF;


END
/



