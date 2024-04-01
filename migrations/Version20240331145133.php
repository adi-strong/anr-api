<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240331145133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX name_idx ON fuel_site');
        $this->addSql('ALTER TABLE property DROP status');
        $this->addSql('DROP INDEX brand_idx ON vehicle');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE INDEX name_idx ON fuel_site (name)');
        $this->addSql('ALTER TABLE property ADD status VARCHAR(255) NOT NULL');
        $this->addSql('CREATE INDEX brand_idx ON vehicle (brand)');
    }
}
