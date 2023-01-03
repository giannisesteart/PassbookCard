SELECT * FROM
  (SELECT b.code FROM  
              ( SELECT    email    FROM Guests where code=27824 AND hotelCode=1) a
  INNER JOIN   ( SELECT code, email    FROM GUESTS where hotelCode=1) b
  ON   a.email = b.email) c 
    INNER JOIN REGISTRATIONS ON c.code=REGISTRATIONS.guestcode  
      WHERE serialnumber='AH3'
  