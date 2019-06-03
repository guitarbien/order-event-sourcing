#language: zh-TW

功能: Order APIs

  場景: 成立訂單
    假定 API 網址為 "/api/orders"
    而且 API JSON資料為
      """
        {"contact_name":"John Doe","contact_address":"my address","contact_mobile":"0912345678","products":[{"prod_oid":7781,"prod_name":"商品 aaa","qty":2,"price":370},{"prod_oid":7782,"prod_name":"商品 bbb","qty":3,"price":99},{"prod_oid":7783,"prod_name":"商品 ccc","qty":2,"price":450}]}
      """
    當 以 "POST" 方法要求 API
    那麼 回傳狀態應為 201
    而且 資料表 "orders" 應有資料
      | contact_name | contact_address | contact_mobile | price |
      | John Doe     | my address      | 0912345678     | 1487  |
