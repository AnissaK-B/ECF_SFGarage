<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240125095547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, marque VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, year DATE NOT NULL, milage VARCHAR(255) NOT NULL, INDEX IDX_773DE69DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, day_of_week VARCHAR(255) NOT NULL, opening_time TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', closing_time TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', INDEX IDX_5A3811FBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_E19D9AD2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE testimonials (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, car_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, comment LONGTEXT NOT NULL, rate SMALLINT NOT NULL, approved TINYINT(1) NOT NULL, INDEX IDX_38311579A76ED395 (user_id), INDEX IDX_38311579C3C6F69F (car_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE testimonials ADD CONSTRAINT FK_38311579A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE testimonials ADD CONSTRAINT FK_38311579C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE user ADD name VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DA76ED395');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FBA76ED395');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2A76ED395');
        $this->addSql('ALTER TABLE testimonials DROP FOREIGN KEY FK_38311579A76ED395');
        $this->addSql('ALTER TABLE testimonials DROP FOREIGN KEY FK_38311579C3C6F69F');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE testimonials');
        $this->addSql('ALTER TABLE user DROP name, DROP lastname');
    }
}
