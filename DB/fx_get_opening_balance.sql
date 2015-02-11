CREATE DEFINER=`root`@`%` FUNCTION `fx_get_opening_balance`(_transaction_date DATE, _coa_id INT) RETURNS double
    DETERMINISTIC
BEGIN

  DECLARE done1 INT DEFAULT FALSE;
    DECLARE _amount, _balance DOUBLE;
    DECLARE _crdr_jd, _crdr_coa TEXT;
    DECLARE cur1 CURSOR FOR SELECT jd.amount, jd.`crdr` FROM `jurnal_detail` jd JOIN jurnal j ON j.transaction_id = jd.transaction_id WHERE jd.coa_id = _coa_id AND j.transaction_date < _transaction_date AND j.posted = 'YES';
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done1 = TRUE;
    
    set _crdr_coa = (SELECT crdr FROM coa WHERE coa_id =  _coa_id);
    set _balance = 0;
    
    OPEN cur1;
    read_loop1: LOOP
        FETCH cur1 INTO _amount, _crdr_jd;
        IF done1 THEN    
            CLOSE cur1;
            LEAVE read_loop1;
        END IF;
        
        IF _crdr_jd = _crdr_coa THEN
          SET _balance = _balance + _amount;
        ELSE
          SET _balance = _balance - _amount;
        END IF;
    END LOOP read_loop1;
    
    return _balance;
  
END;