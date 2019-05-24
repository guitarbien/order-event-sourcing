#language: zh-TW

功能: User APIs

  場景: 建立使用者
    假定 API 網址為 "/api/users"
    而且 API 附帶資料為
      | name | email            | password |
      | User | user@example.com | example  |
    當 以 "POST" 方法要求 API
    那麼 回傳狀態應為 201
    而且 資料表 "users" 應有資料
      | id | name | email            |
      | 1  | User | user@example.com |
