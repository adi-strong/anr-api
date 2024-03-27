<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240326145112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mission (id INT AUTO_INCREMENT NOT NULL, roadmap_id INT DEFAULT NULL, exit_permit_id INT DEFAULT NULL, mission_order_id INT DEFAULT NULL, expense_id INT DEFAULT NULL, agent_id INT DEFAULT NULL, user_id INT DEFAULT NULL, object VARCHAR(255) NOT NULL, place VARCHAR(255) NOT NULL, start_at DATE DEFAULT NULL, end_at DATE DEFAULT NULL, transport VARCHAR(255) NOT NULL, transport_name VARCHAR(255) DEFAULT NULL, ticket_number VARCHAR(255) DEFAULT NULL, accommodation VARCHAR(255) DEFAULT NULL, accommodation_address LONGTEXT DEFAULT NULL, observation LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_9067F23C135345B2 (roadmap_id), UNIQUE INDEX UNIQ_9067F23CC467131E (exit_permit_id), UNIQUE INDEX UNIQ_9067F23C85636C81 (mission_order_id), UNIQUE INDEX UNIQ_9067F23CF395DB7B (expense_id), INDEX IDX_9067F23C3414710B (agent_id), INDEX IDX_9067F23CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission_agent (mission_id INT NOT NULL, agent_id INT NOT NULL, INDEX IDX_B61DC3A0BE6CAE90 (mission_id), INDEX IDX_B61DC3A03414710B (agent_id), PRIMARY KEY(mission_id, agent_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C135345B2 FOREIGN KEY (roadmap_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CC467131E FOREIGN KEY (exit_permit_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C85636C81 FOREIGN KEY (mission_order_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CF395DB7B FOREIGN KEY (expense_id) REFERENCES expense (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C3414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE mission_agent ADD CONSTRAINT FK_B61DC3A0BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_agent ADD CONSTRAINT FK_B61DC3A03414710B FOREIGN KEY (agent_id) REFERENCES agent (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C135345B2');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CC467131E');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C85636C81');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CF395DB7B');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C3414710B');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CA76ED395');
        $this->addSql('ALTER TABLE mission_agent DROP FOREIGN KEY FK_B61DC3A0BE6CAE90');
        $this->addSql('ALTER TABLE mission_agent DROP FOREIGN KEY FK_B61DC3A03414710B');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE mission_agent');
    }
}
