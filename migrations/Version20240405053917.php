<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240405053917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE property_assignment (id INT AUTO_INCREMENT NOT NULL, doc_object_id INT DEFAULT NULL, agent_id INT DEFAULT NULL, property_id INT DEFAULT NULL, comment LONGTEXT DEFAULT NULL, start_at DATETIME DEFAULT NULL, end_at DATETIME DEFAULT NULL, released_at DATETIME DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_85646489DFF56A4A (doc_object_id), INDEX IDX_856464893414710B (agent_id), INDEX IDX_85646489549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE property_assignment ADD CONSTRAINT FK_85646489DFF56A4A FOREIGN KEY (doc_object_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE property_assignment ADD CONSTRAINT FK_856464893414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE property_assignment ADD CONSTRAINT FK_85646489549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property_assignment DROP FOREIGN KEY FK_85646489DFF56A4A');
        $this->addSql('ALTER TABLE property_assignment DROP FOREIGN KEY FK_856464893414710B');
        $this->addSql('ALTER TABLE property_assignment DROP FOREIGN KEY FK_85646489549213EC');
        $this->addSql('DROP TABLE property_assignment');
    }
}
