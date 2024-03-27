<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240326161102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE folder (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, doc_object_id INT DEFAULT NULL, agent_id INT DEFAULT NULL, INDEX IDX_ECA209CDC54C8C93 (type_id), UNIQUE INDEX UNIQ_ECA209CDDFF56A4A (doc_object_id), INDEX IDX_ECA209CD3414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE folder_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_deleted TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medical (id INT AUTO_INCREMENT NOT NULL, observation LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medical_file (id INT AUTO_INCREMENT NOT NULL, medical_id INT DEFAULT NULL, doc_object_id INT DEFAULT NULL, user_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_DF6C9C38592AF3BA (medical_id), INDEX IDX_DF6C9C38DFF56A4A (doc_object_id), INDEX IDX_DF6C9C38A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT FK_ECA209CDC54C8C93 FOREIGN KEY (type_id) REFERENCES folder_type (id)');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT FK_ECA209CDDFF56A4A FOREIGN KEY (doc_object_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT FK_ECA209CD3414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE medical_file ADD CONSTRAINT FK_DF6C9C38592AF3BA FOREIGN KEY (medical_id) REFERENCES medical (id)');
        $this->addSql('ALTER TABLE medical_file ADD CONSTRAINT FK_DF6C9C38DFF56A4A FOREIGN KEY (doc_object_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE medical_file ADD CONSTRAINT FK_DF6C9C38A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE agent ADD profile_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DCCFA12B8 FOREIGN KEY (profile_id) REFERENCES image_object (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_268B9C9DCCFA12B8 ON agent (profile_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE folder DROP FOREIGN KEY FK_ECA209CDC54C8C93');
        $this->addSql('ALTER TABLE folder DROP FOREIGN KEY FK_ECA209CDDFF56A4A');
        $this->addSql('ALTER TABLE folder DROP FOREIGN KEY FK_ECA209CD3414710B');
        $this->addSql('ALTER TABLE medical_file DROP FOREIGN KEY FK_DF6C9C38592AF3BA');
        $this->addSql('ALTER TABLE medical_file DROP FOREIGN KEY FK_DF6C9C38DFF56A4A');
        $this->addSql('ALTER TABLE medical_file DROP FOREIGN KEY FK_DF6C9C38A76ED395');
        $this->addSql('DROP TABLE folder');
        $this->addSql('DROP TABLE folder_type');
        $this->addSql('DROP TABLE medical');
        $this->addSql('DROP TABLE medical_file');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DCCFA12B8');
        $this->addSql('DROP INDEX UNIQ_268B9C9DCCFA12B8 ON agent');
        $this->addSql('ALTER TABLE agent DROP profile_id');
    }
}
