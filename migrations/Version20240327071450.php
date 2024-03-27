<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327071450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, province_id INT DEFAULT NULL, agent_id INT DEFAULT NULL, image_object_id INT DEFAULT NULL, postal_code VARCHAR(6) DEFAULT NULL, avenue VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, quarter VARCHAR(255) DEFAULT NULL, commune VARCHAR(255) DEFAULT NULL, surface VARCHAR(255) NOT NULL, pieces INT DEFAULT NULL, price NUMERIC(10, 6) DEFAULT NULL, description LONGTEXT DEFAULT NULL, status VARCHAR(255) NOT NULL, is_available TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_8BF21CDEC54C8C93 (type_id), INDEX IDX_8BF21CDEE946114A (province_id), UNIQUE INDEX UNIQ_8BF21CDE3414710B (agent_id), UNIQUE INDEX UNIQ_8BF21CDEFBAF8D7F (image_object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_deleted TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEC54C8C93 FOREIGN KEY (type_id) REFERENCES property_type (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEE946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE3414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEFBAF8D7F FOREIGN KEY (image_object_id) REFERENCES image_object (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEC54C8C93');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEE946114A');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE3414710B');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEFBAF8D7F');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE property_type');
    }
}
