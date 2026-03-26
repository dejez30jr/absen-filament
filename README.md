# ==============================
# SETUP ABSEN FILAMENT (DOWNLOAD ZIP)
# ==============================

# Masuk ke folder htdocs
cd htdocs

# Download ZIP dari GitHub
curl -L -o absen-filament.zip https://github.com/dejez30jr/absen-filament/archive/refs/heads/main.zip

# Extract ZIP
tar -xf absen-filament.zip

# Rename folder hasil extract
mv absen-filament-main absen-filament

# Masuk ke folder project
cd absen-filament

# Buka di VS Code
code .

# Install dependency
composer install

# Setup environment
cp .env.example .env

# Generate app key
php artisan key:generate

# Migrasi database
php artisan migrate

# Seeder data
php artisan db:seed



# ==============================
# SETUP ABSEN FILAMENT (GIT CLONE)
# ==============================

# Masuk ke htdocs
cd htdocs

# Clone repo
git clone https://github.com/dejez30jr/absen-filament.git

# Masuk ke folder project
cd absen-filament

# Buka di VS Code
code .

# Install dependency
composer install

# Setup environment
cp .env.example .env

# Generate app key
php artisan key:generate

# Migrasi database
php artisan migrate

# Seeder data
php artisan db:seed

# Jalankan server
php artisan serve

# Jalankan server
php artisan serve
