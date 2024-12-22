# To-Do List App

Aplikacja "To-Do List" to prosty system do zarządzania zadaniami. Umożliwia dodawanie, edytowanie, przeglądanie oraz usuwanie zadań, a także zarządzanie priorytetami, terminami wykonania i statusami zadań. Dodatkowo, aplikacja wysyła powiadomienia e-mail o zadaniach, które mają zbliżający się termin wykonania.

## Technologie

-   PHP 8.1+
-   Laravel 11
-   MySQL/SQLite
-   Node.js i npm (dla frontend)

### Opcjonalne wymagania:

-   Docker (dla łatwego uruchomienia projektu)

## Instalacja

### 1. Klonowanie repozytorium

Klonuj repozytorium na swoje lokalne środowisko:

```bash
git clone git@github.com:spinomik/Simple_toDoList.git
cd Simple_toDoList
```

### 2. Konfiguracja .env

Skopiuj plik `.env.example` i utwórz plik `.env`:

```bash
cp .env.example .env
```

Skonfiguruj dane dostępowe do bazy danych oraz ustawienia aplikacji, smtp, dane dockera, dane bazy danych dane administratora

### Uruchamianie

```bash
docker-compose build
docker-compose up -d
```

Docker automatycznie zainstaluje wszystkie potrzebne zaleznosci i wykona migracje oraz tworzenie rekordow przez seeder'a, jesli chcesz uruchomic lokalnie aplikacje bez dockera:

```bash
npm install
coposer install
php artisan migrate
php artisan db:seed
php artisan serve
```

Możesz teraz otworzyć aplikację w przeglądarce: [http://localhost:8000]\*.
\*port oraz domena moze sie roznic zaleznie od ustawień

## Funkcjonalności

### 1. CRUD na zadaniach

Użytkownicy mogą tworzyć, edytować, usuwać oraz przeglądać zadania, które zawierają następujące dane:

-   **osoba przypisana**(mozliwos edycji tylko dla administratora)
-   **Nazwa zadania** (max. 255 znaków)
-   **Opis** (opcjonalny)
-   **Priorytet** (`low`, `medium`, `high`)
-   **Status** (`to-do`, `in progress`, `done`)
-   **Termin wykonania** (wymagane)

### 2. Filtrowanie zadań

Możliwość filtrowania listy zadań według:

-   **Przypisanego uzytkownika** (tylko administrator, uzytkownicy widzą tylko swoje zadania)
-   **nazwy zadania** (wystarczy fragment nazwy)
-   **Priorytetu** (low/medium/high)
-   **Statusu** (to-do/in-progress/done)
-   **Terminu wykonania** (np. zadania zbliżające się do daty wykonania)

### 3. Sortowanie zadań

Możliwość filtrowania listy zadań według:

-   **Przypisanego uzytkownika** (tylko administrator, uzytkownicy widzą tylko swoje zadania)
-   **nazwy zadania** (wystarczy fragment nazwy)
-   **Priorytetu** (low/medium/high)
-   **Statusu** (to-do/in-progress/done)
-   **Terminu wykonania** (np. zadania zbliżające się do daty wykonania)

### 4. Powiadomienia e-mail

Aplikacja wysyła powiadomienia e-mail do użytkowników na **1 dzień przed terminem zadania**. Powiadomienia są realizowane przy użyciu kolejek (queues) oraz harmonogramu (scheduler) w Laravelu. Dodatkowo powiadomienia są wysyłane tylko do uzytkowników, gdzie zadanie ma status **in progress** lub **to-do**, harmonogram sprawdza co **5min** listę zadań i dodaje do kolejki, a po wysłaniu powiadomienia dodaje flagę **notification_sent** do zadania w tabeli "tasks", w celu unikania wysyłaniawielu wiadomości, przy edycji zadania flaga jesy usuwana i wiadomość zostanei wysłana ponownie.

### 5. Walidacja

Formularze są walidowane na wszystkich etapach (frontend + backend), aby upewnić się, że dane są poprawne. Wymagana jest m.in.:

-   **Nazwa zadania** (max. 255 znaków, obowiązkowe)
-   **Opis** (jeśli podany, nie dłuższy niż 1000 znaków)
-   **Priorytet** i **Status** muszą mieć odpowiednie wartości
-   **Termin wykonania** (data, wymagane)
-   **Osoba przypisana** (administrator moze stworzyc zadanie dla innej osoby)

### 6. Obsługa wielu użytkowników

Aplikacja umożliwia tworzenie kont użytkowników, którzy mogą logować się i zarządzać swoimi zadaniami (domyslny uzytkownik ma dostep tylko do zakładki task - read/edit/delete/create), używając mechanizmu uwierzytelniania wbudowanego w Laravel. Dodatkowo został dodany middleware do zarzadzania uprawnieniami. Uzytkownik posiadajacy role **ADMIN** ma dostęp do wszystkich czynnosci, w zakładce **Users** moze edytować uprawenienia, usunąć konto czy zablokować uzytkownika. Zablokowany uzytkownik nie moze zalogowac sie do systemu i otrzyma informacje o blokadzie konta. Mozna rowniez w panelu uzytkownika zmienic hasło, dane uzytkownika lub usunąć konto.

## Dodatkowe funkcje (opcjonalne)

### 7. Historia edycji zadań

Aplikacja zapisuje każdą zmianę wykonaną na zadaniach, umożliwiając użytkownikowi przeglądanie poprzednich wersji zadań w szczegółach danego zadania (nazw, opisów, priorytetów, statusów, dat, przypisanego uzytkownik, osoby edytujacej zadanie).

### 8. Udostępnianie zadań

Użytkownicy mogą generować **publiczne linki** do zadań, które są dostępne przez określony czas. Linki zawierają token dostępu, po którego wygaśnięciu dostęp zostaje zablokowany. Dodatkowo token mozna wczesniej deaktywowac w konkretnym zadaniu lub w ustawieniach profilu. Generowanie tokenu dostepne tylko dla administratora i osoby z uprawnieniami **PUBLIC_TOKEN_GENERATE**, token domyslnie jest wazny przez 60min, wartosc nalezy ustawic w pliku ENV **PUBLIC_TOKEN_EXPIRY** , tokeny mozna tez podejrzeć w ustawieniach profilu i przy uprawnieniach **PUBLIC_TOKEN_DELETE** lub **ADMIN** usunąć,

<!-- ### 9. Integracja z Google Calendar

Aplikacja umożliwia przypinanie ważnych zadań do **Google Calendar**. Użytkownicy mogą synchronizować zadania z Google Kalendarzem za pomocą biblioteki **Spatie Laravel Google Calendar**. -->

### Features

    - logowanie google/appleId
    - dodanie integracji z google calendar/apple calendar
    - dark mode
    - zmiana jezyka
    - optymalizacja (podział widoków na komponenty)
    - przepisac role uzytkowikow (spatie/laravel-permission)
    - naprawic importowanie flowbite
    - naprawic resetowanie hasla
    - dostosowac i ujednolicić powiadomienia
    - dodać zakłądkę dla administratorów to zarządzania tokenami publicznymi
    - dodać moliwośc zmiany statusu bez edycji zadania
    - strona główna(dodać podgląd aktualnych zadań)
    - dodać archiwum wykonanych zadań
    - poprawić okno filtrów w tasks
    - dodać testy

## Struktura projektu

-   **app/** - Logika aplikacji
    -   **Models/** - Modele Eloquent
    -   **Http/** - Kontrolery i API
    -   **Jobs/** - Kolejki i zadania do wykonania
-   **resources/** - Frontend
    -   **views/** - Widoki Blade
-   **database/** - Migracje i seedery
-   **routes/** - Definicje routingu aplikacji

## Wymagania techniczne

-   Laravel 11
-   REST API i Eloquent ORM
-   MySQL jako baza danych
-   Front-end z użyciem Blade, Flowbite, alpinejs
-   Konfiguracja aplikacji w Dockerze

## Docker (opcjonalnie)

W przypadku chęci używania aplikacji w środowisku Docker, możesz uruchomić aplikację używając:

```bash
docker-compose up --build
```

## Autorzy

Projekt stworzony przez Mikołaj Majewski.

## Licencja

Ten projekt jest dostępny na licencji MIT.
