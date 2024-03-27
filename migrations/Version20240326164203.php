<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240326164203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assignment (id INT AUTO_INCREMENT NOT NULL, origin_id INT DEFAULT NULL, destination_id INT DEFAULT NULL, agent_id INT DEFAULT NULL, start_at DATE DEFAULT NULL, end_at DATE DEFAULT NULL, is_active TINYINT(1) NOT NULL, paths JSON DEFAULT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_30C544BA56A273CC (origin_id), INDEX IDX_30C544BA816C6140 (destination_id), INDEX IDX_30C544BA3414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA56A273CC FOREIGN KEY (origin_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA816C6140 FOREIGN KEY (destination_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA3414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BA56A273CC');
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BA816C6140');
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BA3414710B');
        $this->addSql('DROP TABLE assignment');
    }
}
