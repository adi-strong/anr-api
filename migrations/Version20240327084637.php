<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327084637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fuel (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, stock DOUBLE PRECISION DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fuel_site (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address LONGTEXT DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fuel_site_fuel (fuel_site_id INT NOT NULL, fuel_id INT NOT NULL, INDEX IDX_4C717653598164E0 (fuel_site_id), INDEX IDX_4C71765397C79677 (fuel_id), PRIMARY KEY(fuel_site_id, fuel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fuel_stock_supply (id INT AUTO_INCREMENT NOT NULL, fuel_id INT DEFAULT NULL, supply_id INT DEFAULT NULL, quantity DOUBLE PRECISION NOT NULL, INDEX IDX_2280F8E997C79677 (fuel_id), INDEX IDX_2280F8E9FF28C0D8 (supply_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fuel_supply (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refueling (id INT AUTO_INCREMENT NOT NULL, site_id INT DEFAULT NULL, fuel_id INT DEFAULT NULL, vehicle_id INT DEFAULT NULL, agent_id INT DEFAULT NULL, quantity DOUBLE PRECISION NOT NULL, created_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_5C524674F6BD1646 (site_id), UNIQUE INDEX UNIQ_5C52467497C79677 (fuel_id), UNIQUE INDEX UNIQ_5C524674545317D1 (vehicle_id), INDEX IDX_5C5246743414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fuel_site_fuel ADD CONSTRAINT FK_4C717653598164E0 FOREIGN KEY (fuel_site_id) REFERENCES fuel_site (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fuel_site_fuel ADD CONSTRAINT FK_4C71765397C79677 FOREIGN KEY (fuel_id) REFERENCES fuel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fuel_stock_supply ADD CONSTRAINT FK_2280F8E997C79677 FOREIGN KEY (fuel_id) REFERENCES fuel (id)');
        $this->addSql('ALTER TABLE fuel_stock_supply ADD CONSTRAINT FK_2280F8E9FF28C0D8 FOREIGN KEY (supply_id) REFERENCES fuel_supply (id)');
        $this->addSql('ALTER TABLE refueling ADD CONSTRAINT FK_5C524674F6BD1646 FOREIGN KEY (site_id) REFERENCES fuel_site (id)');
        $this->addSql('ALTER TABLE refueling ADD CONSTRAINT FK_5C52467497C79677 FOREIGN KEY (fuel_id) REFERENCES fuel (id)');
        $this->addSql('ALTER TABLE refueling ADD CONSTRAINT FK_5C524674545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE refueling ADD CONSTRAINT FK_5C5246743414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fuel_site_fuel DROP FOREIGN KEY FK_4C717653598164E0');
        $this->addSql('ALTER TABLE fuel_site_fuel DROP FOREIGN KEY FK_4C71765397C79677');
        $this->addSql('ALTER TABLE fuel_stock_supply DROP FOREIGN KEY FK_2280F8E997C79677');
        $this->addSql('ALTER TABLE fuel_stock_supply DROP FOREIGN KEY FK_2280F8E9FF28C0D8');
        $this->addSql('ALTER TABLE refueling DROP FOREIGN KEY FK_5C524674F6BD1646');
        $this->addSql('ALTER TABLE refueling DROP FOREIGN KEY FK_5C52467497C79677');
        $this->addSql('ALTER TABLE refueling DROP FOREIGN KEY FK_5C524674545317D1');
        $this->addSql('ALTER TABLE refueling DROP FOREIGN KEY FK_5C5246743414710B');
        $this->addSql('DROP TABLE fuel');
        $this->addSql('DROP TABLE fuel_site');
        $this->addSql('DROP TABLE fuel_site_fuel');
        $this->addSql('DROP TABLE fuel_stock_supply');
        $this->addSql('DROP TABLE fuel_supply');
        $this->addSql('DROP TABLE refueling');
    }
}
