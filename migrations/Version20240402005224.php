<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240402005224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent_state ADD doc_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agent_state ADD CONSTRAINT FK_9A3DFA83895648BC FOREIGN KEY (doc_id) REFERENCES doc_object (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9A3DFA83895648BC ON agent_state (doc_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent_state DROP FOREIGN KEY FK_9A3DFA83895648BC');
        $this->addSql('DROP INDEX UNIQ_9A3DFA83895648BC ON agent_state');
        $this->addSql('ALTER TABLE agent_state DROP doc_id');
    }
}
