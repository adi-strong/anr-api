<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328003333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX is_deleted_idx ON agent');
        $this->addSql('DROP INDEX is_deleted_idx ON department');
        $this->addSql('DROP INDEX is_deleted_idx ON department_service');
        $this->addSql('DROP INDEX is_deleted_idx ON expense_type');
        $this->addSql('DROP INDEX is_deleted_idx ON folder_type');
        $this->addSql('DROP INDEX is_deleted_idx ON fuel');
        $this->addSql('DROP INDEX is_deleted_idx ON fuel_site');
        $this->addSql('DROP INDEX is_deleted_idx ON grade');
        $this->addSql('DROP INDEX is_deleted_idx ON job');
        $this->addSql('ALTER TABLE mission ADD is_deleted TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE INDEX is_deleted_idx ON agent (is_deleted)');
        $this->addSql('CREATE INDEX is_deleted_idx ON department (is_deleted)');
        $this->addSql('CREATE INDEX is_deleted_idx ON department_service (is_deleted)');
        $this->addSql('CREATE INDEX is_deleted_idx ON expense_type (is_deleted)');
        $this->addSql('CREATE INDEX is_deleted_idx ON folder_type (is_deleted)');
        $this->addSql('CREATE INDEX is_deleted_idx ON fuel (is_deleted)');
        $this->addSql('CREATE INDEX is_deleted_idx ON fuel_site (is_deleted)');
        $this->addSql('CREATE INDEX is_deleted_idx ON grade (is_deleted)');
        $this->addSql('CREATE INDEX is_deleted_idx ON job (is_deleted)');
        $this->addSql('ALTER TABLE mission DROP is_deleted');
    }
}
