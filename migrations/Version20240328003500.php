<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328003500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX is_deleted_idx ON mission');
        $this->addSql('ALTER TABLE mission DROP is_deleted');
        $this->addSql('ALTER TABLE property ADD is_deleted TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mission ADD is_deleted TINYINT(1) DEFAULT NULL');
        $this->addSql('CREATE INDEX is_deleted_idx ON mission (is_deleted)');
        $this->addSql('ALTER TABLE property DROP is_deleted');
    }
}
