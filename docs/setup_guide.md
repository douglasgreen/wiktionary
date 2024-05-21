# Project Setup Guide

## Setup Scripts

This project uses the
[GitLab script system](https://github.blog/2015-06-30-scripts-to-rule-them-all/).
To set up the project, run:

```bash
script/setup
```

## Linting, Fixing, and Testing

### PHP

-   Lint: `composer lint`
-   Fix: `composer lint:fix`

### JavaScript

-   Fix: `npm run lint:fix`

## Pre-commit Hooks

Linting and testing are automatically run by `.husky/pre-commit`. Fix any errors
or use `--no-verify` to bypass the check.

## Commitlint

[Conventional Commits](https://www.npmjs.com/package/@commitlint/config-conventional)
are enforced by `.husky/pre-commit`. Fix any lint errors before committing.
