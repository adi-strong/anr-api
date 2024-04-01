<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328185550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9D487CFC8E');
        $this->addSql('DROP INDEX IDX_268B9C9D487CFC8E ON agent');
        $this->addSql('ALTER TABLE agent ADD god_father VARCHAR(255) NOT NULL, DROP god_father_id');
        $this->addSql('DROP INDEX name_idx ON department');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent ADD god_father_id INT DEFAULT NULL, DROP god_father');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D487CFC8E FOREIGN KEY (god_father_id) REFERENCES agent (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_268B9C9D487CFC8E ON agent (god_father_id)');
        $this->addSql('CREATE INDEX name_idx ON department (name)');
    }
}
