
## install

run `composer install`

## BDD with behat
The BDD spec is at `./features`, run behat with: `vendor/bin/behat --append-snippets`

## API Documents
Designing API with [api-blueprint](http://apiblueprint.org) at `./api-blueprint`, and generate it with [aglio](https://github.com/danielgtaylor/aglio).
You can install aglio globally or only with the project.

For example, generate the document to the public folder from api-blueprint: `./node_modules/aglio/bin/aglio.js -i api-blueprint/User.md -o public/doc/index.html`, and you can see [the document](http://your-project-domain/doc)

## phpcs
If you want to exec phpcs with every commit: `cp ./git-hooks/pre-commit .git/pre-commit`
