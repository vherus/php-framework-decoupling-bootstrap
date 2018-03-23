# vherus/php-framework

## What it is
A custom bootstrap framework for HTTP, API and Console based PHP applications.

## What's in the box
Features include:

- *Console*: a starting point for building CLI applications
- *Http/App*: a starting point for building GUIs
- *Http/ApiV1*: a starting point for building APIs
- *Http/Healthcheck*: a starting point for building a healthcheck endpoint for monitoring tools

## Getting started

### Pre-requisites
- [docker-ce](https://www.docker.com/community-edition)
- [docker-compose](https://docs.docker.com/compose)

### Cloning the repository
`git clone git@github.com:vherus/php-framework.git <YOUR_APP_NAME>`

Do not delete the whole `.git` folder. Having a shared git history with the framework will make it easy to merge changes from it to your app.

Delete the `origin` remote, and re-add it named `upstream`. This allows you to merge the framework branches into your app by simply doing `git merge upstream <BRANCH>`.

Git remotes for dummies:

`git remote rm origin`

`git remote add upstream https://github.com/vherus/php-framework.git`

Create a new Github repository and add it as remote `origin`.

`git remote add origin https://github.com/<USER>/<APP>`

### Rename the package
Find and replace all occurrences of "Vherus" in this repository with a name suitable for your application - ensuring to preserve case sensitivity.

This will include renaming things such as:

- composer.json name
- Docker image names
- PHP namespaces

### Delete what you don't need
You should **delete what don't need**. For example if you never intend to have a GUI, delete the Http/App namespace entirely.

Deleting unused code helps ensure any applications built from this do not have redundant/dead code.

You can always revert the deletion later if you do need it.

### Easy start mode

Once you've completed the pre-requisite steps above, let's go!

1. Run `bin/setup` from the project root directory
2. Go make a coffee