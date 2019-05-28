#language: zh-TW

功能: User APIs

  背景:
    假定 存在使用者 "User" "user@example.com"

  場景: 建立使用者
    假定 API 網址為 "/api/users"
    而且 API 附帶資料為
      | name     | email                | password |
      | John Doe | john.doe@example.com | abcd1234  |
    當 以 "POST" 方法要求 API
    那麼 回傳狀態應為 201
    而且 資料表 "users" 應有資料
      | id | name     | email                |
      | 2  | John Doe | john.doe@example.com |

  場景: 查詢使用者
    假定 API 網址為 "/api/users/1"
    當 以 "GET" 方法要求 API
    那麼 回傳狀態應為 200
    而且 可以得到Json回傳值
      | id | name | email            |
      | 1  | User | user@example.com |
