<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230629154329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, count_books INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) NOT NULL, image LONGBLOB NOT NULL, year_public INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('INSERT INTO author(name,count_books) VALUES (\'Иванов Иван Петрович\', 0)');
        $this->addSql('INSERT INTO author(name,count_books) VALUES (\'Иванов Ивана Петровна\', 0)');
        $this->addSql('INSERT INTO author(name,count_books) VALUES (\'Иванович Иван Петровичввв\', 0)');
        $this->addSql('INSERT INTO book(name,description,image,year_public) VALUES (\'Золушка\',\'Из мультфильма\',\'\', 1996)');
        $this->addSql('INSERT INTO book(name,description,image,year_public) VALUES (\'Трое из Лас-Вегаса\',\'Из мультфильма\',\'\', 1997)');
        $this->addSql('INSERT INTO book(name,description,image,year_public) VALUES (\'Побез из замка\',\'Из мультфильма\',\'\', 2022)');
        $this->addSql('CREATE TABLE author_books (book_id INT NOT NULL, author_id INT NOT NULL, INDEX IDX_5C930A5F16A2B381 (book_id), INDEX IDX_5C930A5FF675F31B (author_id), PRIMARY KEY(book_id, author_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE author_books ADD CONSTRAINT FK_5C930A5F16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE ON UPDATE CASCADE ');
        $this->addSql('ALTER TABLE author_books ADD CONSTRAINT FK_5C930A5FF675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE ON UPDATE CASCADE ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author_books DROP FOREIGN KEY FK_5C930A5F16A2B381');
        $this->addSql('ALTER TABLE author_books DROP FOREIGN KEY FK_5C930A5FF675F31B');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE author_books');
    }
}
