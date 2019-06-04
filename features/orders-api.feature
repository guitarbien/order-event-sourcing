#language: zh-TW

功能: Order APIs

  場景: 成立訂單
    假定 API 網址為 "/api/orders"
    而且 API JSON資料為
      """
        {"contact_name":"John Doe","contact_address":"my address","contact_mobile":"0912345678","contact_email":"guitarbien@gmail.com", "products":[{"prod_oid":7781,"prod_name":"product aaa","qty":2,"price":370},{"prod_oid":7782,"prod_name":"product bbb","qty":3,"price":99},{"prod_oid":7783,"prod_name":"product ccc","qty":2,"price":450}]}
      """
    當 以 "POST" 方法要求 API
    那麼 回傳狀態應為 201
    而且 資料表 "orders" 應有資料
      | contact_name | contact_address | contact_mobile | contact_email        | price |
      | John Doe     | my address      | 0912345678     | guitarbien@gmail.com | 1937  |
    而且 資料表 "order_products" 應有資料
      | id | prod_oid | prod_name   | qty | price_unit | price_sum |
      | 1  | 7781     | product aaa | 2   | 370        | 740       |
      | 2  | 7782     | product bbb | 3   | 99         | 297       |
      | 3  | 7783     | product ccc | 2   | 450        | 900       |
