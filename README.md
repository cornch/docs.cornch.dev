# `\Cornch\Docs::class`

`\Cornch\Docs::class` is a website that aims to provide translated documentations of Laravel framework and various Laravel's 1st party packages.

## Installation

1. Install Git Submodules

```bash
git submodule update --init --recursive
```

2. Install Dependencies
```bash
composer install
npm ci
```

3. Configure `.env`
```bash
cp .env.example .env
php artisan key:generate
```

4. Compile Assets
```bash
npm run build
```

## License

```
cornch/docs.cornch.dev
Copyright (C) 2022 Cornch

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
```

Translations & documentations might use different license. See each components inside [resources/docs/](resources/docs) for more detail.
