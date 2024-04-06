<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240406162657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE refueling DROP INDEX UNIQ_5C524674F6BD1646, ADD INDEX IDX_5C524674F6BD1646 (site_id)');
        $this->addSql('ALTER TABLE refueling DROP INDEX UNIQ_5C52467497C79677, ADD INDEX IDX_5C52467497C79677 (fuel_id)');
        $this->addSql('ALTER TABLE refueling DROP INDEX UNIQ_5C524674545317D1, ADD INDEX IDX_5C524674545317D1 (vehicle_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE refueling DROP INDEX IDX_5C524674F6BD1646, ADD UNIQUE INDEX UNIQ_5C524674F6BD1646 (site_id)');
        $this->addSql('ALTER TABLE refueling DROP INDEX IDX_5C52467497C79677, ADD UNIQUE INDEX UNIQ_5C52467497C79677 (fuel_id)');
        $this->addSql('ALTER TABLE refueling DROP INDEX IDX_5C524674545317D1, ADD UNIQUE INDEX UNIQ_5C524674545317D1 (vehicle_id)');
    }
}
