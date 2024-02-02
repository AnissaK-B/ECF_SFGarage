<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240129075859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schedule ADD morning_hours VARCHAR(255) NOT NULL, ADD evening_hours VARCHAR(255) NOT NULL, DROP opening_time, DROP closing_time');
        $this->addSql('ALTER TABLE testimonials DROP FOREIGN KEY FK_3831157956AE248B');
        $this->addSql('DROP INDEX IDX_3831157956AE248B ON testimonials');
        $this->addSql('ALTER TABLE testimonials DROP user1_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schedule ADD opening_time VARCHAR(255) NOT NULL, ADD closing_time VARCHAR(255) NOT NULL, DROP morning_hours, DROP evening_hours');
        $this->addSql('ALTER TABLE testimonials ADD user1_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE testimonials ADD CONSTRAINT FK_3831157956AE248B FOREIGN KEY (user1_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_3831157956AE248B ON testimonials (user1_id)');
    }
}
