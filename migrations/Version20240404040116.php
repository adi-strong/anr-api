<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240404040116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment ADD origin_province_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BAE192F73D FOREIGN KEY (origin_province_id) REFERENCES province (id)');
        $this->addSql('CREATE INDEX IDX_30C544BAE192F73D ON assignment (origin_province_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BAE192F73D');
        $this->addSql('DROP INDEX IDX_30C544BAE192F73D ON assignment');
        $this->addSql('ALTER TABLE assignment DROP origin_province_id');
    }
}
