<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190423115404 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE note CHANGE user_id user_id BIGINT DEFAULT NULL, CHANGE idea_id idea_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE ex_company CHANGE idea_id idea_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE favorites RENAME INDEX fk_user_has_idea_user1_idx TO IDX_E46960F5A76ED395');
        $this->addSql('ALTER TABLE favorites RENAME INDEX fk_user_has_idea_idea1_idx TO IDX_E46960F55B6FEF7D');
        $this->addSql('ALTER TABLE ex_images CHANGE idea_id idea_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE idea ADD user_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE idea ADD CONSTRAINT FK_A8BCA45A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A8BCA45A76ED395 ON idea (user_id)');
        $this->addSql('ALTER TABLE idea_has_category RENAME INDEX fk_idea_has_category_idea1_idx TO IDX_14A2B1875B6FEF7D');
        $this->addSql('ALTER TABLE idea_has_category RENAME INDEX fk_idea_has_category_category1_idx TO IDX_14A2B18712469DE2');
        $this->addSql('ALTER TABLE ex_url CHANGE idea_id idea_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE badges_has_user RENAME INDEX fk_badges_has_user_badges1_idx TO IDX_9AC2F4BC538DA1D0');
        $this->addSql('ALTER TABLE badges_has_user RENAME INDEX fk_badges_has_user_user1_idx TO IDX_9AC2F4BCA76ED395');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE badges_has_user RENAME INDEX idx_9ac2f4bca76ed395 TO fk_badges_has_user_user1_idx');
        $this->addSql('ALTER TABLE badges_has_user RENAME INDEX idx_9ac2f4bc538da1d0 TO fk_badges_has_user_badges1_idx');
        $this->addSql('ALTER TABLE ex_company CHANGE idea_id idea_id BIGINT NOT NULL');
        $this->addSql('ALTER TABLE ex_images CHANGE idea_id idea_id BIGINT NOT NULL');
        $this->addSql('ALTER TABLE ex_url CHANGE idea_id idea_id BIGINT NOT NULL');
        $this->addSql('ALTER TABLE favorites RENAME INDEX idx_e46960f55b6fef7d TO fk_user_has_idea_idea1_idx');
        $this->addSql('ALTER TABLE favorites RENAME INDEX idx_e46960f5a76ed395 TO fk_user_has_idea_user1_idx');
        $this->addSql('ALTER TABLE idea DROP FOREIGN KEY FK_A8BCA45A76ED395');
        $this->addSql('DROP INDEX IDX_A8BCA45A76ED395 ON idea');
        $this->addSql('ALTER TABLE idea DROP user_id');
        $this->addSql('ALTER TABLE idea_has_category RENAME INDEX idx_14a2b18712469de2 TO fk_idea_has_category_category1_idx');
        $this->addSql('ALTER TABLE idea_has_category RENAME INDEX idx_14a2b1875b6fef7d TO fk_idea_has_category_idea1_idx');
        $this->addSql('ALTER TABLE note CHANGE idea_id idea_id BIGINT NOT NULL, CHANGE user_id user_id BIGINT NOT NULL');
    }
}
