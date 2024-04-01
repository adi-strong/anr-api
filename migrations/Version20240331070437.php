<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240331070437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX name_idx ON fuel_site');
        $this->addSql('ALTER TABLE fuel_stock_supply ADD site_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fuel_stock_supply ADD CONSTRAINT FK_2280F8E9F6BD1646 FOREIGN KEY (site_id) REFERENCES fuel_site (id)');
        $this->addSql('CREATE INDEX IDX_2280F8E9F6BD1646 ON fuel_stock_supply (site_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE INDEX name_idx ON fuel_site (name)');
        $this->addSql('ALTER TABLE fuel_stock_supply DROP FOREIGN KEY FK_2280F8E9F6BD1646');
        $this->addSql('DROP INDEX IDX_2280F8E9F6BD1646 ON fuel_stock_supply');
        $this->addSql('ALTER TABLE fuel_stock_supply DROP site_id');
    }
}
