<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240330135807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX first_name_idx ON agent');
        $this->addSql('DROP INDEX full_name_idx ON agent');
        $this->addSql('DROP INDEX last_name_idx ON agent');
        $this->addSql('DROP INDEX name_idx ON agent');
        $this->addSql('ALTER TABLE salary ADD total NUMERIC(10, 6) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE INDEX first_name_idx ON agent (first_name)');
        $this->addSql('CREATE INDEX full_name_idx ON agent (name, last_name, first_name)');
        $this->addSql('CREATE INDEX last_name_idx ON agent (last_name)');
        $this->addSql('CREATE INDEX name_idx ON agent (name)');
        $this->addSql('ALTER TABLE salary DROP total');
    }
}
