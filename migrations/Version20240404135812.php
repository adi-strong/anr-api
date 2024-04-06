<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240404135812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vehicle_assignment (id INT AUTO_INCREMENT NOT NULL, doc_object_id INT DEFAULT NULL, agent_id INT DEFAULT NULL, vehicle_id INT DEFAULT NULL, comment LONGTEXT DEFAULT NULL, start_at DATETIME DEFAULT NULL, end_at DATETIME DEFAULT NULL, released_at DATETIME DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_B557CB27DFF56A4A (doc_object_id), INDEX IDX_B557CB273414710B (agent_id), INDEX IDX_B557CB27545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vehicle_assignment ADD CONSTRAINT FK_B557CB27DFF56A4A FOREIGN KEY (doc_object_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE vehicle_assignment ADD CONSTRAINT FK_B557CB273414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE vehicle_assignment ADD CONSTRAINT FK_B557CB27545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE vehicle ADD agent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4863414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1B80E4863414710B ON vehicle (agent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicle_assignment DROP FOREIGN KEY FK_B557CB27DFF56A4A');
        $this->addSql('ALTER TABLE vehicle_assignment DROP FOREIGN KEY FK_B557CB273414710B');
        $this->addSql('ALTER TABLE vehicle_assignment DROP FOREIGN KEY FK_B557CB27545317D1');
        $this->addSql('DROP TABLE vehicle_assignment');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E4863414710B');
        $this->addSql('DROP INDEX UNIQ_1B80E4863414710B ON vehicle');
        $this->addSql('ALTER TABLE vehicle DROP agent_id');
    }
}
