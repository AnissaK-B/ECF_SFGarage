<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240126121318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE testimonials ADD user1_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE testimonials ADD CONSTRAINT FK_3831157956AE248B FOREIGN KEY (user1_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3831157956AE248B ON testimonials (user1_id)');
        $this->addSql('ALTER TABLE user DROP name');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE testimonials DROP FOREIGN KEY FK_3831157956AE248B');
        $this->addSql('DROP INDEX IDX_3831157956AE248B ON testimonials');
        $this->addSql('ALTER TABLE testimonials DROP user1_id');
        $this->addSql('ALTER TABLE user ADD name VARCHAR(255) NOT NULL');
    }
}
