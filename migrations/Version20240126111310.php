<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240126111310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_employee (id INT AUTO_INCREMENT NOT NULL, service_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_A4E92E9CED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service_employee ADD CONSTRAINT FK_A4E92E9CED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DA76ED395');
        $this->addSql('DROP INDEX IDX_773DE69DA76ED395 ON car');
        $this->addSql('ALTER TABLE car DROP user_id, CHANGE year year INT NOT NULL, CHANGE milage milage INT NOT NULL, CHANGE price image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE testimonials DROP FOREIGN KEY FK_38311579C3C6F69F');
        $this->addSql('DROP INDEX IDX_38311579C3C6F69F ON testimonials');
        $this->addSql('ALTER TABLE testimonials DROP car_id');
        $this->addSql('ALTER TABLE user ADD service_id INT DEFAULT NULL, DROP lastname');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649ED5CA9E6 ON user (service_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649ED5CA9E6');
        $this->addSql('ALTER TABLE service_employee DROP FOREIGN KEY FK_A4E92E9CED5CA9E6');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE service_employee');
        $this->addSql('ALTER TABLE car ADD user_id INT DEFAULT NULL, CHANGE milage milage VARCHAR(255) NOT NULL, CHANGE year year DATE NOT NULL, CHANGE image price VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_773DE69DA76ED395 ON car (user_id)');
        $this->addSql('ALTER TABLE testimonials ADD car_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE testimonials ADD CONSTRAINT FK_38311579C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_38311579C3C6F69F ON testimonials (car_id)');
        $this->addSql('DROP INDEX IDX_8D93D649ED5CA9E6 ON user');
        $this->addSql('ALTER TABLE user ADD lastname VARCHAR(255) NOT NULL, DROP service_id');
    }
}
